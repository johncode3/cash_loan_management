<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Loan;
use Illuminate\Auth\Access\Response;

class LoanPolicy
{
    /**
     * Create a new policy instance.
     */
    public function approve(User $user): bool
    {
        return in_array($user->role, ['loan_officer', 'admin']);
    }

    public function disburse(User $user, ?Loan $loan = null): bool
    {
        if ($user->role !== 'admin') {
            return false;
        }
        if ($loan && $loan->status !== 'Approved') {
            return false;
        }
        return true;
    }

    public function repay(User $user, ?Loan $loan = null): bool
    {
        if (!in_array($user->role, ['cashier', 'admin'])) {
            return false;
        }
        if ($loan) {
            return $loan->status === 'Disbursed';
        }
        return true;
    }

    public function apply (User $user): bool
    {
        return in_array($user->role, ['customer', 'admin']);
    }
}
