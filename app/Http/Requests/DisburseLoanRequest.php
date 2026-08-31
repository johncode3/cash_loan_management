<?php

namespace App\Http\Requests;

use App\Models\Loan;
use Illuminate\Foundation\Http\FormRequest;

class DisburseLoanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() && $this->user()->role === 'admin';
    }

    public function rules(): array
    {
        return [];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $loanId = $this->route('id');
            $loan = Loan::find($loanId);

            if (! $loan) {
                $validator->errors()->add('disburse_error', 'Loan record not found.');
                return;
            }

            if ($loan->status === 'Disbursed') {
                $validator->errors()->add('disburse_error', 'This loan has already been disbursed! Duplicate disbursement is strictly prohibited.');
            } 
            elseif ($loan->status !== 'Approved') {
                $validator->errors()->add('disburse_error', 'This loan cannot be disbursed because it has not been approved yet.');
            }
        });
    }
}