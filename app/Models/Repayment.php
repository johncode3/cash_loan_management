<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Repayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'schedule_id',
        'amount_paid',
        'payment_date',
        'payment_method',
        'received_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid'  => 'decimal:2',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function schedule()
    {
        return $this->belongsTo(LoanSchedule::class, 'schedule_id');
    }

    public function cashier()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}