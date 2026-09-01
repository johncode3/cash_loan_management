<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'category_id',
        'principal_amount',
        'interest_rate',
        'term_months',
        'status',
        'disbursement_date',
        'created_by',
    ];

    protected $casts = [
        'principal_amount' => 'decimal:2',
        'interest_rate'    => 'decimal:2',
        'term_months'      => 'integer',
        'disbursement_date'=> 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function schedules()
    {
        return $this->hasMany(LoanSchedule::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function repayments()
    {
        return $this->hasMany(Repayment::class);
    }
}