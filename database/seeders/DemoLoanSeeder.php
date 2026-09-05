<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Category;
use App\Models\Loan;
use App\Models\User;
use App\Services\LoanCalculationService;
use Illuminate\Database\Seeder;

class DemoLoanSeeder extends Seeder
{
    public function run(): void
    {
        $calculator = new LoanCalculationService();
        $admin = User::where('role', 'admin')->first();
        $officer = User::where('role', 'loan_officer')->first();
        $customerUser = User::where('role', 'customer')->first();
        
        $customer1 = Customer::where('email', 'customer@loan.com')->first();
        $customer2 = Customer::where('customer_code', 'CUST-0002')->first();
        $customer3 = Customer::where('customer_code', 'CUST-0003')->first();
        $customer4 = Customer::where('customer_code', 'CUST-0004')->first();

        $catPersonal = Category::where('name', 'Personal Loan')->first();
        $catSme = Category::where('name', 'Business / SME Loan')->first();
        $catAgri = Category::where('name', 'Agriculture Loan')->first();

        if ($customer2) {
            Loan::updateOrCreate(
                ['customer_id' => $customer2->id, 'principal_amount' => 1500.00],
                [
                    'category_id'       => $catSme?->id,
                    'principal_amount'  => 1500.00,
                    'interest_rate'     => 2.00,
                    'term_months'       => 6,
                    'status'            => 'Pending',
                    'disbursement_date' => null,
                    'created_by'        => $customerUser?->id,
                ]
            );
        }

        if ($customer3) {
            Loan::updateOrCreate(
                ['customer_id' => $customer3->id, 'principal_amount' => 2000.00],
                [
                    'category_id'       => $catAgri?->id,
                    'principal_amount'  => 2000.00,
                    'interest_rate'     => 2.00,
                    'term_months'       => 6,
                    'status'            => 'Approved',
                    'disbursement_date' => null,
                    'created_by'        => $officer?->id,
                ]
            );
        }

        if ($customer1) {
            $loan3 = Loan::updateOrCreate(
                ['customer_id' => $customer1->id, 'principal_amount' => 1000.00],
                [
                    'category_id'       => $catPersonal?->id,
                    'principal_amount'  => 1000.00,
                    'interest_rate'     => 2.00,
                    'term_months'       => 6,
                    'status'            => 'Disbursed',
                    'disbursement_date' => now()->subMonths(1),
                    'created_by'        => $officer?->id,
                ]
            );

            if ($loan3->schedules()->count() === 0) {
                $schedules = $calculator->generateSchedule(1000.00, 2.00, 6, now()->subMonths(1)->format('Y-m-d'));
                foreach ($schedules as $sch) {
                    $loan3->schedules()->create($sch);
                }
            }
        }

        if ($customer4) {
            $loan4 = Loan::updateOrCreate(
                ['customer_id' => $customer4->id, 'principal_amount' => 800.00],
                [
                    'category_id'       => $catPersonal?->id,
                    'principal_amount'  => 800.00,
                    'interest_rate'     => 2.00,
                    'term_months'       => 6,
                    'status'            => 'Disbursed',
                    'disbursement_date' => now()->subMonths(2),
                    'created_by'        => $admin?->id,
                ]
            );

            if ($loan4->schedules()->count() === 0) {
                $schedules = $calculator->generateSchedule(800.00, 2.00, 6, now()->subMonths(2)->format('Y-m-d'));
                foreach ($schedules as $idx => $sch) {
                    if ($idx === 0) {
                        $sch['status'] = 'Overdue';
                        $sch['due_date'] = now()->subDays(15)->format('Y-m-d');
                    }
                    $loan4->schedules()->create($sch);
                }
            }
        }
    }
}