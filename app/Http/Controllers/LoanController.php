<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Customer;
use App\Models\Category;
use App\Models\Loan;


class LoanController extends Controller
{
    public function create()
    {
        $customers = Customer::where('status', 'Active')->orderBy('first_name')->get();
        $categories = Category::orderBy('name')->get();
        return view('loans.apply', compact('customers', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id'      => 'required|exists:customers,id',
            'category_id'      => 'nullable|exists:categories,id',
            'principal_amount' => 'required|numeric|min:50|max:100000',
            'interest_rate'    => 'required|numeric|min:0.1|max:50',
            'term_months'      => 'required|integer|min:1|max:60',
        ]);

        $validated['status'] = 'Pending';
        $validated['created_by'] = Auth::id();

        Loan::create($validated);
        return redirect()->route('loans.pending')->with('success', 'Loan application submitted successfully! Status is Pending approval.');
    }

    public function index() {}

    public function show($id) {}

    public function approve($id) {
        $loan = Loan::findOrFail($id);
        if ($loan->status !== 'Pending') {
            return redirect()->back()->with('error', 'Only pending loans can be approved.');
        }

        $loan->update(['status' => 'Approved']);
        return redirect()->route('loans.pending')->with('success', "Loan #{$loan->id} for {$loan->customer->first_name} {$loan->customer->last_name} has been approved successfully!");
    }

    public function pending(Request $request) {
        $query = Loan::with(['customer', 'category'])->where('status', 'Pending');

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
    public function disburse($id) {}

    public function schedule($id) {}
}
