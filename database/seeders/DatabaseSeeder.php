<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $password = Hash::make('password123');

        // 1. Admin Account
        User::updateOrCreate(
            ['email' => 'admin@loan.com'],
            ['name' => 'System Admin', 'role' => 'admin', 'password' => $password, 'email_verified_at' => now()]
        );

        // 2. Loan Officer Accounts
        User::updateOrCreate(
            ['email' => 'officer@loan.com'],
            ['name' => 'Sokha (Loan Officer)', 'role' => 'loan_officer', 'password' => $password, 'email_verified_at' => now()]
        );
        User::updateOrCreate(
            ['email' => 'officer2@loan.com'],
            ['name' => 'Piseth (Loan Officer)', 'role' => 'loan_officer', 'password' => $password, 'email_verified_at' => now()]
        );

        // 3. Cashier Accounts
        User::updateOrCreate(
            ['email' => 'cashier@loan.com'],
            ['name' => 'Chanthy (Cashier)', 'role' => 'cashier', 'password' => $password, 'email_verified_at' => now()]
        );
        User::updateOrCreate(
            ['email' => 'cashier2@loan.com'],
            ['name' => 'Sreypov (Cashier)', 'role' => 'cashier', 'password' => $password, 'email_verified_at' => now()]
        );

        // 4. Case Study Customer Account (Dara Sok)
        User::updateOrCreate(
            ['email' => 'customer@loan.com'],
            ['name' => 'Dara Sok', 'role' => 'customer', 'password' => $password, 'email_verified_at' => now()]
        );

        // 5. Run all Master Data & Demo Loan Seeders
        $this->call([
            CategorySeeder::class,
            DummyDataSeeder::class,
            DemoLoanSeeder::class,
        ]);
    }
}