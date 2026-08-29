<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DummySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $khmerLastNames  = ['Sok', 'Chan', 'Keo', 'Chea', 'Heng', 'Meng', 'Lim', 'Vann', 'Rath', 'Sam', 'Phan', 'Thy', 'Nguon', 'Bou', 'Ros', 'Chhim'];
        $khmerFirstNames = ['Dara', 'Bona', 'Sreypov', 'Piseth', 'Kosal', 'Chanthy', 'Vannak', 'Sokha', 'Sophea', 'Rithy', 'Thida', 'Bopha', 'Ratha', 'Chenda', 'Vireak', 'Sovan'];
        
        $provinces = [
            'Phnom Penh', 'Kandal', 'Siem Reap', 'Battambang', 'Kampong Cham', 
            'Kampong Speu', 'Kampot', 'Takeo', 'Prey Veng', 'Banteay Meanchey'
        ];

        $departments = [
            'Credit & Lending'       => ['Loan Officer', 'Senior Loan Officer', 'Branch Manager'],
            'Finance & Accounting'   => ['Accountant', 'Cashier'],
            'Operations & Cashier'   => ['Cashier', 'Customer Service Officer'],
            'Administration & HR'    => ['HR Officer', 'Security'],
            'Information Technology' => ['IT Support'],
        ];

        for ($i = 1; $i <= 20; $i++) {
            $gender = $faker->randomElement(['Male', 'Female']);
            $firstName = $faker->randomElement($khmerFirstNames);
            $lastName  = $faker->randomElement($khmerLastNames);
            $code = 'CUST-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            Customer::updateOrCreate(
                ['customer_code' => $code],
                [
                    'customer_code' => $code,
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'gender'        => $gender,
                    'date_of_birth' => $faker->dateTimeBetween('1975-01-01', '2004-12-31')->format('Y-m-d'),
                    'phone'         => '0' . $faker->randomElement(['12', '10', '97', '88', '77', '92']) . $faker->numerify('######'),
                    'email'         => strtolower($firstName . '.' . $lastName . $i . '@gmail.com'),
                    'address'       => 'St. ' . $faker->numberBetween(100, 999) . ', Sangkat ' . $faker->citySuffix,
                    'city'          => $faker->randomElement($provinces),
                    'status'        => $faker->randomElement(['Active', 'Active', 'Active', 'Inactive']),
                ]
            );
        }

        for ($j = 1; $j <= 15; $j++) {
            $deptName = $faker->randomElement(array_keys($departments));
            $posName  = $faker->randomElement($departments[$deptName]);
            $gender   = $faker->randomElement(['Male', 'Female']);
            $firstName = $faker->randomElement($khmerFirstNames);
            $lastName  = $faker->randomElement($khmerLastNames);
            $email     = strtolower($firstName . '.' . $lastName . $j . '@company.com');

            Employee::updateOrCreate(
                ['email' => $email],
                [
                    'first_name'      => $firstName,
                    'last_name'       => $lastName,
                    'gender'          => $gender,
                    'date_of_birth'   => $faker->dateTimeBetween('1980-01-01', '2003-12-31')->format('Y-m-d'),
                    'position'        => $posName,
                    'department'      => $deptName,
                    'phone'           => '0' . $faker->randomElement(['12', '10', '97', '88', '77']) . $faker->numerify('######'),
                    'email'           => $email,
                    'address'         => 'St. ' . $faker->numberBetween(100, 999) . ', Phnom Penh',
                    'hiring_date'     => $faker->dateTimeBetween('2020-01-01', '2025-12-31')->format('Y-m-d'),
                    'salary'          => $faker->randomFloat(2, 350, 2200),
                    'status'          => $faker->randomElement(['Active', 'Active', 'Active', 'Inactive', 'Resigned']),
                    'profile_picture' => null,
                ]
            );
        }
    }
}