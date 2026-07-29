<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Employee extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'first_name',
        'last_name',
        'gender',
        'date_of_birth',
        'position',
        'department',
        'phone',
        'email',
        'address',
        'hiring_date',
        'salary',
        'status',
        'profile_picture',
    ];
}