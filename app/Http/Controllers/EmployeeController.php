<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Employee::query();
        $query->when($request->filled('first_name'), fn ($q) => $q->where('first_name', 'like', '%' . $request->first_name . '%'));
        $query->when($request->filled('last_name'), fn ($q) => $q->where('last_name', 'like', '%' . $request->last_name . '%'));
        $query->when($request->filled('department'), fn ($q) => $q->where('department', 'like', '%' . $request->department . '%'));
        $query->when($request->filled('status'), fn ($q) => $q->where('status', 'like', '%' . $request->status . '%'));
        $orderBy = $request->input('order_by', 'id');
        $orderDir = $request->input('order_dir', 'asc');
        $allowedOrderBy = ['id', 'first_name', 'last_name', 'hiring_date', 'salary'];
        if (!in_array($orderBy, $allowedOrderBy)) {
            $orderBy = 'id';
        }
        $orderDir = $orderDir === 'desc' ? 'desc' : 'asc';
        $employees = $query->orderBy($orderBy, $orderDir)->paginate(15)->withQueryString();
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('employees.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name'        => ['required', 'string',],
            'last_name'         => ['required', 'string',],
            'gender'            => ['required', Rule::in(['male', 'female'])],
            'date_of_birth'     => ['required', 'date'],
            'position'          => ['nullable', 'string',],
            'department'        => ['nullable', 'string',],
            'phone'             => ['nullable', 'string',],
            'email'             => ['nullable', 'email', 'unique:employees,email'],
            'address'           => ['nullable', 'string',],
            'hiring_date'       => ['required', 'date'],
            'salary'            => ['required', 'numeric', 'min:0'],
            'status'            => ['required', Rule::in(['Active', 'Inactive', 'Terminated', 'Resigned'])],
            'profile_picture'   => ['nullable', 'image',],
        ]);

        if ($request->hasFile('profile_picture')) {
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        }

        Employee::create($validated);
        return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.show', compact('employee'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $employee = Employee::findOrFail($id);
        return view('employees.edit', compact('employee'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $employee = Employee::findOrFail($id);
        $validated = $request->validate([
            'first_name'        => ['required', 'string',],
            'last_name'         => ['required', 'string',],
            'gender'            => ['required', Rule::in(['male', 'female'])],
            'date_of_birth'     => ['required', 'date'],
            'position'          => ['nullable', 'string',],
            'department'        => ['nullable', 'string',],
            'phone'             => ['nullable', 'string',],
            'email'             => ['nullable', 'email', Rule::unique('employees', 'email')->ignore($employee->id)],
            'address'           => ['nullable', 'string',],
            'hiring_date'        => ['required', 'date'],
            'salary'            => ['required', 'numeric', 'min:0'],
            'status'            => ['required', Rule::in(['Active', 'Inactive', 'Terminated', 'Resigned'])],
            'profile_picture'   => ['nullable', 'image',],
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($employee->profile_picture) {
                Storage::disk('public')->delete($employee->profile_picture);
            }
            $validated['profile_picture'] = $request->file('profile_picture')->store('profile_pictures', 'public');
        } else {
            unset($validated['profile_picture']);
        }

        $employee->update($validated);
        return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $employee = Employee::findOrFail($id);
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
