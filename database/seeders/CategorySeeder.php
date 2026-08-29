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
                'description' => 'កម្ចីផ្ទាល់ខ្លួន - Short-term quick cash loan for personal expenses, medical emergencies, and daily needs.',
            ],
            [
                'name'        => 'Business / SME Loan',
                'description' => 'កម្ចីអាជីវកម្ម - Working capital financing for small grocery shops, retail stores, and inventory purchases.',
            ],
            [
                'name'        => 'Agriculture Loan',
                'description' => 'កម្ចីកសិកម្ម - Seasonal financing for crop cultivation, fertilizer, seeds, and agricultural machinery.',
            ],
            [
                'name'        => 'Education Loan',
                'description' => 'កម្ចីការសិក្សា - Tuition fee support for university students and vocational training programs.',
            ],
            [
                'name'        => 'Home Improvement Loan',
                'description' => 'កម្ចីជួសជុលផ្ទះ - Financing for home renovations, roof repairs, water sanitation, and solar installation.',
            ],
            [
                'name'        => 'Vehicle / Motor Loan',
                'description' => 'កម្ចីទិញយានយន្ត - Installment financing for purchasing motorcycles, tuk-tuks, and delivery vehicles.',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                ['description' => $category['description']]
            );
        }
    }
}