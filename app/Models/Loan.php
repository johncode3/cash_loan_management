<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
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

    /**
     * Type casting for financial fields and dates.
     */
    protected $casts = [
        'principal_amount' => 'decimal:2',
        'interest_rate'    => 'decimal:2',
        'term_months'      => 'integer',
        'disbursement_date'=> 'date',
    ];

    /**
     * The customer who borrowed the money.
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * The loan product category (Personal, Business, etc.).
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * The User / Loan Officer who created the application.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}