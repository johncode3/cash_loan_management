@extends('layouts.app')
@section('title', 'Edit Employee')
@section('main')
        <h1>Edit Employee</h1>
        @if ($errors->any())
            <div style="border:1px solid #f5c6cb; background:#f8d7da; padding:10px; margin-bottom:16px; border-radius:4px">
                <strong>There are some problems with your input:</strong>
                <ul style="margin: 8px 0 0 20px">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach 
                </ul>
            </div>
        @endif
        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $employee->first_name) }}" required>
                @error('first_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $employee->last_name) }}" required>
                @error('last_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender', strtolower($employee->gender)) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender', strtolower($employee->gender)) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $employee->date_of_birth) }}" required>
                @error('date_of_birth')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" value="{{ old('position', $employee->position) }}" required>
                @error('position')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="{{ old('department', $employee->department) }}" required>
                @error('department')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone', $employee->phone) }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $employee->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address', $employee->address) }}" required>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="hiring_date">Hire Date:</label>
                <input type="date" id="hiring_date" name="hiring_date" value="{{ old('hiring_date', $employee->hiring_date) }}" required>
                @error('hiring_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="{{ old('salary', $employee->salary) }}" step="0.01" required>
                @error('salary')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active" {{ old('status',$employee->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status',$employee->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Terminated" {{ old('status',$employee->status) == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="Resigned" {{ old('status',$employee->status) == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                @if ($employee->profile_picture)
                    <div style="margin-bottom: 8px">
                        <img src="{{ asset('storage/' . $employee->profile_picture) }}" alt="Current Picture" style="height: 80px; border-radius:4px">
                        <span style="margin-left: 10px; font-size: 0.9rem; color:#555050">Current Picture</span>
                    </div>
                @endif
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                @error('profile_picture')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="action">
                <button type="submit" class="btn btn-primary">Update Employee</button>
                <a href="{{ route('employees.index')}}" class="btn btn-secondary" style="margin-left: 12px">Cancel</a>
            </div>
        </form>
@endsection