<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Services\LoanCalculationService;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\DisburseLoanRequest;

class LoanController extends Controller
{
    public function create()
    {
        $user = Auth::user();
        $myCustomer = null;
        $customers = collect();

        if ($user->role === 'customer') {
            $nameParts = explode(' ', $user->name, 2);
            $firstName = $nameParts[0] ?? $user->name;
            $lastName  = $nameParts[1] ?? 'Customer';

            $myCustomer = Customer::firstOrCreate(
                ['email' => $user->email],
                [
                    'customer_code' => 'CUST-' . now()->format('dmy-His'),
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'gender'        => 'Male',
                    'phone'         => '012' . rand(100000, 999999),
                    'address'       => 'Phnom Penh',
                    'city'          => 'Phnom Penh',
                    'status'        => 'Active',
                ]
            );
        } else {
            $customers = Customer::where('status', 'Active')->orderBy('first_name')->get();
        }

        $categories = Category::orderBy('name')->get();

        return view('loans.apply', compact('customers', 'categories', 'myCustomer'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'customer') {
            $customer = Customer::where('email', $user->email)->first();
            $customerId = $customer ? $customer->id : $request->customer_id;
        } else {
            $customerId = $request->customer_id;
        }

        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'category_id'      => 'nullable|exists:categories,id',
            'principal_amount' => 'required|numeric|min:50|max:100000',
            'interest_rate'    => 'required|numeric|min:0.1|max:50',
            'term_months'      => 'required|integer|min:1|max:60',
        ]);

        $validated['customer_id'] = $customerId;
        $validated['status']      = 'Pending';
        $validated['created_by']  = $user->id;

        Loan::create($validated);

        return redirect()->route('dashboard')->with('success', 'Loan application submitted successfully! Status is Pending approval.');
    }

    public function approve($id) {
        $loan = Loan::findOrFail($id);
        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending loans can be approved.');
        }

        $loan->update(['status' => 'Approved']);
        return redirect()->route('loans.pending')->with('success', "Loan #{$loan->id} for {$loan->customer->first_name} {$loan->customer->last_name} has been approved successfully!");
    }

    public function pending(Request $request)
    {
        $query = Loan::with(['customer', 'category'])
            ->whereIn('status', ['Pending']);

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%");
            });
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('loans.pending', compact('loans'));
    }

    public function disburse(DisburseLoanRequest $request, $id, LoanCalculationService $calculator)
    {
        $loan = Loan::with('schedules')->findOrFail($id);

        DB::transaction(function () use ($loan, $calculator) {

            $loan->update([
                'status'            => 'Disbursed',
                'disbursement_date' => now(),
            ]);

            $scheduleData = $calculator->generateSchedule(
                (float) $loan->principal_amount,
                (float) $loan->interest_rate,
                (int) $loan->term_months,
                now()->format('Y-m-d')
            );
            
            foreach ($scheduleData as $row) {
                $loan->schedules()->create($row);
            }
        });

        return redirect()->route('loans.schedule', $loan->id)->with('success', 'Loan disbursed successfully! Repayment schedule has been generated.');
    }

    public function schedule($id)
    {
        $loan = Loan::with(['customer', 'category', 'schedules' => function ($q) {
            $q->orderBy('installment_no');
        }])->findOrFail($id);

        return view('loans.schedule', compact('loan'));
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Loan::with(['customer', 'category', 'schedules']);

        if ($user->role === 'customer') {
            $customer = Customer::where('email', $user->email)->first();
            $query->where('customer_id', $customer ? $customer->id : 0);
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $loans = $query->latest()->paginate(10)->withQueryString();

        return view('loans.index', compact('loans'));
    }

    public function show($id)
    {
        $loan = Loan::with([
            'customer',
            'category',
            'creator',
            'schedules',
            'repayments.cashier',
        ])->findOrFail($id);

        $totalPrincipal   = (float) $loan->principal_amount;
        $totalScheduleDue = (float) $loan->schedules->sum('total_due');
        $totalPaid        = (float) $loan->repayments->sum('amount_paid');
        $remainingBalance = max(0, $totalScheduleDue - $totalPaid);

        return view('loans.show', compact('loan', 'totalPrincipal', 'totalPaid', 'remainingBalance', 'totalScheduleDue'));
    }
}
