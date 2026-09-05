<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Employee;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DummyDataSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        $khmerLastNames  = ['Sok', 'Chan', 'Keo', 'Chea', 'Heng', 'Meng', 'Lim', 'Vann', 'Rath', 'Sam', 'Phan', 'Thy', 'Nguon', 'Bou'];
        $khmerFirstNames = ['Dara', 'Bona', 'Sreypov', 'Piseth', 'Kosal', 'Chanthy', 'Vannak', 'Sokha', 'Sophea', 'Rithy', 'Thida', 'Bopha', 'Ratha', 'Chenda'];
        
        $provinces = ['Phnom Penh', 'Kandal', 'Siem Reap', 'Battambang', 'Kampong Cham', 'Kampot', 'Takeo', 'Sihanoukville'];

        $departments = [
            'Credit & Lending'       => ['Loan Officer', 'Senior Loan Officer', 'Branch Manager'],
            'Finance & Accounting'   => ['Accountant', 'Cashier'],
            'Operations & Cashier'   => ['Cashier', 'Customer Service Officer'],
            'Administration & HR'    => ['HR Officer', 'Security'],
            'Information Technology' => ['IT Support'],
        ];

        Customer::updateOrCreate(
            ['email' => 'customer@loan.com'],
            [
                'customer_code' => 'CUST-0001',
                'first_name'    => 'Dara',
                'last_name'     => 'Sok',
                'gender'        => 'Male',
                'date_of_birth' => '1995-05-15',
                'phone'         => '012345678',
                'email'         => 'customer@loan.com',
                'address'       => 'St. 271, Sangkat Boeung Tumpun',
                'city'          => 'Phnom Penh',
                'status'        => 'Active',
            ]
        );

        for ($i = 2; $i <= 20; $i++) {
            $gender = $i % 2 === 0 ? 'Female' : 'Male';
            $firstName = $khmerFirstNames[($i - 1) % count($khmerFirstNames)];
            $lastName  = $khmerLastNames[($i - 1) % count($khmerLastNames)];
            $code = 'CUST-' . str_pad($i, 4, '0', STR_PAD_LEFT);

            Customer::updateOrCreate(
                ['customer_code' => $code],
                [
                    'customer_code' => $code,
                    'first_name'    => $firstName,
                    'last_name'     => $lastName,
                    'gender'        => $gender,
                    'date_of_birth' => $faker->dateTimeBetween('1982-01-01', '2004-12-31')->format('Y-m-d'),
                    'phone'         => '0' . $faker->randomElement(['12', '10', '97', '88', '77', '92']) . $faker->numerify('######'),
                    'email'         => strtolower($firstName . '.' . $lastName . $i . '@gmail.com'),
                    'address'       => 'St. ' . $faker->numberBetween(100, 800) . ', Village ' . $faker->numberBetween(1, 10),
                    'city'          => $provinces[($i - 1) % count($provinces)],
                    'status'        => $i === 18 ? 'Inactive' : 'Active', // 1 inactive to test status filter
                ]
            );
        }

        $deptKeys = array_keys($departments);
        for ($j = 1; $j <= 10; $j++) {
            $deptName  = $deptKeys[($j - 1) % count($deptKeys)];
            $posList   = $departments[$deptName];
            $posName   = $posList[($j - 1) % count($posList)];
            $gender    = $j % 2 === 0 ? 'Female' : 'Male';
            $firstName = $khmerFirstNames[($j + 2) % count($khmerFirstNames)];
            $lastName  = $khmerLastNames[($j + 1) % count($khmerLastNames)];

            Employee::updateOrCreate(
                ['email' => strtolower($firstName . '.' . $lastName . $j . '@company.com')],
                [
                    'first_name'      => $firstName,
                    'last_name'       => $lastName,
                    'gender'          => $gender,
                    'date_of_birth'   => $faker->dateTimeBetween('1985-01-01', '2000-12-31')->format('Y-m-d'),
                    'position'        => $posName,
                    'department'      => $deptName,
                    'phone'           => '0' . $faker->randomElement(['12', '10', '97', '88', '77']) . $faker->numerify('######'),
                    'email'           => strtolower($firstName . '.' . $lastName . $j . '@company.com'),
                    'address'         => 'St. ' . $faker->numberBetween(100, 500) . ', Phnom Penh',
                    'hiring_date'     => $faker->dateTimeBetween('2021-01-01', '2025-12-31')->format('Y-m-d'),
                    'salary'          => $faker->randomFloat(2, 450, 1800),
                    'status'          => $j === 10 ? 'Resigned' : 'Active',
                    'profile_picture' => null,
                ]
            );
        }
    }
}