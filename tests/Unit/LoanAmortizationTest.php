<?php

namespace Tests\Unit;

use App\Services\LoanCalculationService;
use PHPUnit\Framework\TestCase;

class LoanAmortizationTest extends TestCase
{

    public function test_sum_of_principal_due_equals_original_principal_amount(): void
    {
        $calculator = new LoanCalculationService();

        $principal = 1000.00;
        $interestRate = 2.00;
        $termMonths = 6;

        $schedule = $calculator->generateSchedule($principal, $interestRate, $termMonths);

        $sumPrincipalDue = array_sum(array_column($schedule, 'principal_due'));

        $this->assertEquals(
            round($principal, 2),
            round($sumPrincipalDue, 2),
            "The sum of principal_due ($sumPrincipalDue) must equal original principal ($principal)."
        );

        $this->assertCount(6, $schedule);
    }

    public function test_principal_sum_for_twelve_month_loan(): void
    {
        $calculator = new LoanCalculationService();

        $principal = 5000.00;
        $interestRate = 1.50;
        $termMonths = 12;

        $schedule = $calculator->generateSchedule($principal, $interestRate, $termMonths);
        $sumPrincipalDue = array_sum(array_column($schedule, 'principal_due'));

        $this->assertEquals(round($principal, 2), round($sumPrincipalDue, 2));
        $this->assertCount(12, $schedule);
    }
}