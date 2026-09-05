<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Customer::query();
        
        $query->when($request->filled('first_name'), fn ($q) => $q->where('first_name', 'like', '%' . $request->first_name . '%'));
        $query->when($request->filled('last_name'), fn ($q) => $q->where('last_name', 'like', '%' . $request->last_name . '%'));
        $query->when($request->filled('phone'), fn ($q) => $q->where('phone', 'like', '%' . $request->phone . '%'));
        $query->when($request->filled('city'), fn ($q) => $q->where('city', 'like', $request->city . '%'));
        $query->when($request->filled('status'), fn ($q) => $q->where('status', $request->status));

        $sort = $request->input('sort', 'id');
        $direction = $request->input('direction', 'desc');

        $allowedSorts = ['id', 'first_name', 'last_name', 'phone', 'city', 'status', 'created_at', 'updated_at'];
        if (!in_array($sort, $allowedSorts)) {
            $sort = 'id';
        }

        $totalCount = Customer::count();
        $activeCount = Customer::where('status', 'Active')->count();

        $customers = $query->orderBy($sort, $direction)
                           ->paginate(10)
                           ->withQueryString();

        $cities = Customer::select('city')
            ->distinct()
            ->pluck('city')
            ->filter()
            ->sort()
            ->values();

       return view('customers.index', compact('customers', 'totalCount', 'activeCount', 'cities'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    { 
            $autoCustomerCode = 'CUST-' . now()->format('dmy-His');
            return view('customers.create', compact('autoCustomerCode'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_code' => ['nullable', 'string', 'unique:customers,customer_code'],
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'gender'        => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date'],
            'phone'         => ['required', 'string', 'unique:customers,phone'],
            'email'         => ['required', 'email', 'unique:customers,email'],
            'address'       => ['nullable', 'string'],
            'city'          => ['nullable', 'string'],
            'status'        => ['required', Rule::in(['Active', 'Inactive'])],
        ]);

        $validated['customer_code'] = 'CUST-' . now()->format('dmy-His');
        $fullName = trim($validated['first_name'] . ' ' . $validated['last_name']);

        DB::transaction(function () use ($validated, $fullName) {
            $customer = Customer::create($validated);

            User::create([
                'name' => $fullName,
                'email' => $validated['email'],
                'password' => Hash::make('password123'),
                'customer_id' => $customer,
            ]);
        });

        return redirect()->route('customers.index')->with('success',"Customer {$fullName} created successfully! Online login account provisioned with default password: password123"
        );
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.show', compact('customer'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $customer = Customer::findOrFail($id);
        return view('customers.edit', compact('customer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'first_name'    => ['required', 'string', 'max:100'],
            'last_name'     => ['required', 'string', 'max:100'],
            'gender'        => ['required', Rule::in(['Male', 'Female'])],
            'date_of_birth' => ['nullable', 'date'],
            'phone'         => ['required', 'string', Rule::unique('customers', 'phone')->ignore($customer->id)],
            'email'         => ['required', 'email', Rule::unique('customers', 'email')->ignore($customer->id)],
            'address'       => ['nullable', 'string'],
            'city'          => ['nullable', 'string'],
            'status'        => ['required', Rule::in(['Active', 'Inactive'])],
        ]);
        
        unset($validated['customer_code']);

        $customer->update($validated);

        return redirect()->route('customers.index')->with('success', "Customer {$customer->first_name} {$customer->last_name} updated successfully.");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();
        return redirect()->route('customers.index')->with('success', 'Customer deleted successfully.');
    }
}
