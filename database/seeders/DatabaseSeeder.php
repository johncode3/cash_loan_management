<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Common password for all test accounts
        $password = Hash::make('12345678');

        // 1. Admin (Can Disburse, View Overdue Dashboard, Manage System)
        User::updateOrCreate(
            ['email' => 'admin@loan.com'],
            [
                'name' => 'System Admin',
                'role' => 'admin',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        // 2. Loan Officer (Can Approve / Reject pending loan applications)
        User::updateOrCreate(
            ['email' => 'officer@loan.com'],
            [
                'name' => 'Johnny (Loan Officer)',
                'role' => 'loan_officer',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        // 3. Cashier (Can Record repayments and view payment receipts)
        User::updateOrCreate(
            ['email' => 'cashier@loan.com'],
            [
                'name' => 'Mav (Cashier)',
                'role' => 'cashier',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );

        // 4. Customer (Can Apply for loans and view personal schedules)
        User::updateOrCreate(
            ['email' => 'customer@loan.com'],
            [
                'name' => 'Kakkada (Customer)',
                'role' => 'customer',
                'password' => $password,
                'email_verified_at' => now(),
            ]
        );
    }
}