<?php

namespace App\Services;

use Carbon\Carbon;

class LoanCalculationService
{
    public function generateSchedule(float $principal, float $monthlyInterestRatePercent, int $termMonths, ?string $startDate = null): array
    {
        $r = ($monthlyInterestRatePercent / 100);
        $P = $principal;
        $n = $termMonths;
        $date = $startDate ? Carbon::parse($startDate) : Carbon::today();

        if ($r > 0) {
            $monthlyPayment = $P * ($r * pow(1 + $r, $n)) / (pow(1 + $r, $n) - 1);
        } else {
            $monthlyPayment = $P / $n;
        }

        $monthlyPayment = round($monthlyPayment, 2);
        $remainingBalance = $P;
        $schedules = [];

        for ($i = 1; $i <= $n; $i++) {
            $dueDate = $date->copy()->addMonths($i)->format('Y-m-d');

            $interestDue = round($remainingBalance * $r, 2);

            if ($i === $n) {
                $principalDue = round($remainingBalance, 2);
                $totalDue = round($principalDue + $interestDue, 2);
                $remainingBalance = 0;
            } else {
                $principalDue = round($monthlyPayment - $interestDue, 2);
                $totalDue = round($principalDue + $interestDue, 2);
                $remainingBalance = round($remainingBalance - $principalDue, 2);
            }

            $schedules[] = [
                'installment_no' => $i,
                'due_date'       => $dueDate,
                'principal_due'  => $principalDue,
                'interest_due'   => $interestDue,
                'total_due'      => $totalDue,
                'status'         => 'Pending',
            ];
        }
        return $schedules;
    }
}