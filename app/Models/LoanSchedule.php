<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'installment_no',
        'due_date',
        'principal_due',
        'interest_due',
        'total_due',
        'status',
        'paid_date',
    ];

    protected $casts = [
        'due_date'      => 'date',
        'paid_date'     => 'date',
        'principal_due' => 'decimal:2',
        'interest_due'  => 'decimal:2',
        'total_due'     => 'decimal:2',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }
}