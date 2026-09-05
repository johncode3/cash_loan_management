<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Personal Loan',
                'description' => 'កម្ចីផ្ទាល់ខ្លួន - Short-term quick cash loan for daily living expenses and personal needs.',
            ],
            [
                'name'        => 'Business / SME Loan',
                'description' => 'កម្ចីអាជីវកម្ម - Working capital financing for small grocery shops, retail stores, and inventory purchases.',
            ],
            [
                'name'        => 'Agriculture Loan',
                'description' => 'កម្ចីកសិកម្ម - Seasonal financing for crop cultivation, fertilizer, seeds, and farm machinery.',
            ],
            [
                'name'        => 'Education Loan',
                'description' => 'កម្ចីការសិក្សា - Tuition fee support for university students and technical vocational training.',
            ],
            [
                'name'        => 'Home Improvement Loan',
                'description' => 'កម្ចីជួសជុលផ្ទះ - Financing for roof repairs, house renovation, water sanitation, and construction.',
            ],
            [
                'name'        => 'Vehicle / Motor Loan',
                'description' => 'កម្ចីទិញយានយន្ត - Installment financing for purchasing motorcycles, passapp tuk-tuks, and delivery cars.',
            ],
            [
                'name'        => 'Emergency Quick Cash',
                'description' => 'កម្ចីបន្ទាន់ - Fast 24-hour emergency disbursement for urgent healthcare and hospital bills.',
            ],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['name' => $cat['name']], ['description' => $cat['description']]);
        }
    }
}