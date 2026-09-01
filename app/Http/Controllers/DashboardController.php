<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        if ($user->role === 'customer') {
            $customer = Customer::where('email', $user->email)->first();
            $customerId = $customer ? $customer->id : null;

            $activeLoan = Loan::with('schedules')
                ->where('customer_id', $customerId)
                ->where('status', 'Disbursed')
                ->latest()
                ->first();

            $nextPayment = null;
            $remainingBalance = 0.00;

            if ($activeLoan) {
                $nextPayment = $activeLoan->schedules
                    ->whereIn('status', ['Pending', 'Overdue'])
                    ->sortBy('installment_no')
                    ->first();

                $totalDue = $activeLoan->schedules->sum('total_due');
                $totalPaid = Repayment::where('loan_id', $activeLoan->id)->sum('amount_paid');
                $remainingBalance = max(0, $totalDue - $totalPaid);
            }

            return view('dashboard.index', compact('activeLoan', 'nextPayment', 'remainingBalance'));
        }

        $totalDisbursed = Loan::where('status', 'Disbursed')->sum('principal_amount');
        $pendingLoansCount = Loan::where('status', 'Pending')->count();
        $overdueLoansCount = LoanSchedule::where('status', 'Overdue')->count();
        $totalCollected = Repayment::sum('amount_paid');
        $totalCustomers = Customer::count();

        return view('dashboard.index', compact(
            'totalDisbursed',
            'pendingLoansCount',
            'overdueLoansCount',
            'totalCollected',
            'totalCustomers'
        ));
    }

    public function overdue(Request $request)
    {
        $query = LoanSchedule::with(['loan.customer', 'loan.category'])
            ->where('status', 'Overdue');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->whereHas('loan.customer', function ($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                  ->orWhere('last_name', 'like', "%{$search}%")
                  ->orWhere('customer_code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $overdueSchedules = $query->orderBy('due_date', 'asc')
            ->paginate(10)
            ->withQueryString();

        $totalOverdueAmount = LoanSchedule::where('status', 'Overdue')->sum('total_due');

        return view('dashboard.overdue', compact('overdueSchedules', 'totalOverdueAmount'));
    }
}