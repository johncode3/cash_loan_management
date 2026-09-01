<?php

namespace App\Http\Controllers;

use App\Models\Loan;
use App\Models\LoanSchedule;
use App\Models\Repayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class RepaymentController extends Controller
{
    public function create(Request $request)
    {
        $loans = Loan::with(['customer', 'schedules'])
            ->where('status', 'Disbursed')
            ->whereHas('schedules', function ($q) {
                $q->whereIn('status', ['Pending', 'Overdue']);
            })
            ->latest()
            ->get();

        $selectedLoan = null;
        $nextSchedule = null;

        if ($request->filled('loan_id')) {
            $selectedLoan = Loan::with(['customer', 'schedules'])->find($request->loan_id);
            if ($selectedLoan) {
                $nextSchedule = $selectedLoan->schedules
                    ->whereIn('status', ['Pending', 'Overdue'])
                    ->sortBy('installment_no')
                    ->first();
            }
        }

        return view('loans.repay', compact('loans', 'selectedLoan', 'nextSchedule'));
    }

    public function store(Request $request, $id)
    {
        $loan = Loan::with('schedules')->findOrFail($id);

        $request->validate([
            'amount_paid'    => 'required|numeric|min:1',
            'payment_method' => 'required|string',
            'payment_date'   => 'required|date',
        ]);

        $amountPaid = (float) $request->amount_paid;

        $unpaidSchedules = $loan->schedules
            ->whereIn('status', ['Pending', 'Overdue'])
            ->sortBy('installment_no');

        if ($unpaidSchedules->isEmpty()) {
            return redirect()->route('loans.show', $loan->id)->with('error', 'This loan is already fully repaid!');
        }

        DB::transaction(function () use ($loan, $unpaidSchedules, $amountPaid, $request) {
            $firstSchedule = $unpaidSchedules->first();

            Repayment::create([
                'loan_id'        => $loan->id,
                'schedule_id'    => $firstSchedule->id,
                'amount_paid'    => $amountPaid,
                'payment_date'   => $request->payment_date,
                'payment_method' => $request->payment_method,
                'received_by'    => Auth::id(),
            ]);

            $remainingMoney = $amountPaid;

            foreach ($unpaidSchedules as $schedule) {
                if ($remainingMoney <= 0) {
                    break;
                }

                $due = (float) $schedule->total_due;

                if ($remainingMoney >= $due) {
                    $schedule->update([
                        'status'    => 'Paid',
                        'paid_date' => $request->payment_date,
                    ]);
                    $remainingMoney = round($remainingMoney - $due, 2);
                } else {
                    break;
                }
            }

            $hasUnpaid = $loan->schedules()->whereIn('status', ['Pending', 'Overdue'])->exists();
            if (! $hasUnpaid) {
                $loan->update(['status' => 'Disbursed']);
            }
        });

        return redirect()->route('loans.show', $loan->id)->with('success', "Payment of $" . number_format($amountPaid, 2) . " recorded successfully by Cashier!");
    }
}