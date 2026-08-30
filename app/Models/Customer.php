<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'customer_code',
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'phone',
        'email',
        'address',
        'city',
        'status',
    ];
    protected static function booted()
    {
        static::creating(function ($customer) {
            if (empty($customer->customer_code)) {
            $customer->customer_code = 'CUST-' . now()->format('dmy-His');
        }
        });
    }
}
