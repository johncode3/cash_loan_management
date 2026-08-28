<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoanAuthorizationTest extends TestCase
{
    use RefreshDatabase; // <-- Add this single line here!

    /**
     * Test 1: Unauthenticated guests are redirected to login.
     */
    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/dashboard');

        $response->assertRedirect('/login');
    }

    /**
     * Test 2 (Task B.7): Customer cannot disburse loans (Gets 403 Forbidden).
     */
    public function test_customer_cannot_disburse_loan(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->post('/loans/1/disburse');

        $response->assertStatus(403);
    }

    /**
     * Test 3: Customer cannot access employee management page.
     */
    public function test_customer_cannot_access_employee_page(): void
    {
        $customer = User::factory()->create([
            'role' => 'customer',
        ]);

        $response = $this->actingAs($customer)->get('/employees');

        $response->assertStatus(403);
    }

    /**
     * Test 4: Admin CAN access employee management page.
     */
    public function test_admin_can_access_employee_page(): void
    {
        $admin = User::factory()->create([
            'role' => 'admin',
        ]);

        $response = $this->actingAs($admin)->get('/employees');

        $response->assertStatus(200);
    }
}