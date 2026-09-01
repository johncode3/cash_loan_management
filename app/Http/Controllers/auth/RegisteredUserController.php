<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    public function create(): View
    {
        return view('auth.register');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'gender'        => ['required', Rule::in(['Male', 'Female'])],
            'phone'         => ['required', 'string', 'max:20', 'unique:customers,phone'],
            'city'          => ['required', 'string', 'max:100'],
            'date_of_birth' => ['nullable', 'date'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email', 'unique:customers,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $fullName = trim($request->first_name . ' ' . $request->last_name);
        $customerCode = 'CUST-' . now()->format('dmy-His');

        DB::transaction(function () use ($request, $fullName, $customerCode) {
            $user = User::create([
                'name'     => $fullName,
                'email'    => $request->email,
                'password' => Hash::make($request->password),
                'role'     => 'customer',
            ]);
            
            Customer::create([
                'customer_code' => $customerCode,
                'first_name'    => $request->first_name,
                'last_name'     => $request->last_name,
                'gender'        => $request->gender,
                'date_of_birth' => $request->date_of_birth,
                'phone'         => $request->phone,
                'email'         => $request->email,
                'address'       => $request->city,
                'city'          => $request->city,
                'status'        => 'Active',
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}