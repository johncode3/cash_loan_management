<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->orderBy('name')->paginate(10)->withQueryString();

        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['admin', 'loan_officer', 'cashier', 'customer'])],
        ]);

        $validated['password'] = Hash::make($validated['password']);

        User::create($validated);

        return redirect()->route('users.index')->with('success', "User account for {$validated['name']} created successfully as " . ucfirst(str_replace('_', ' ', $validated['role'])));
    }

    public function edit(string $id)
    {
        $user = User::findOrFail($id);
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validated = $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'string', 'min:6'],
            'role'     => ['required', Rule::in(['admin', 'loan_officer', 'cashier', 'customer'])],
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', "User account for {$user->name} updated successfully.");
    }

    public function destroy(string $id)
    {
        if ((string) $id === (string) Auth::id()) {
            return redirect()->back()->with('error', 'You cannot delete your own logged-in account!');
        }

        $user = User::findOrFail($id);

        if ($user->role === 'customer') {
            $customer = \App\Models\Customer::where('email', $user->email)->first();

            if ($customer) {
                $hasActiveLoans = \App\Models\Loan::where('customer_id', $customer->id)
                    ->whereIn('status', ['Approved', 'Disbursed'])
                    ->exists();

                if ($hasActiveLoans) {
                    return redirect()->back()->with(
                        'error', 
                        "Cannot delete user '{$user->name}': This customer has active/disbursed loan contracts! Settle all loans before deleting."
                    );
                }
            }
        }
        
        $user->delete();

        return redirect()->route('users.index')->with('success', "User {$user->name} deleted successfully.");
    }
}