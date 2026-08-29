@extends('layouts.app')
@section('title', 'Edit Employee')
@section('content')
<div class="form-container">
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
        <div class="form-row">
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
        </div>
        
        <div class="form-row">
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
        </div>

        <div class="form-row">
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
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="department">Department: <span style="color:#dc2626">*</span></label>
                <select name="department" id="department" required>
                    <option value="">-- Select Department --</option>
                    @php
                        $departments = [
                            'Credit & Lending'        => 'Credit & Lending',
                            'Finance & Accounting'    => 'Finance & Accounting',
                            'Operations & Cashier'    => 'Operations & Cashier',
                            'Customer Support'        => 'Customer Support',
                            'Administration & HR'     => 'Administration & HR',
                            'Information Technology'  => 'IT & Systems',
                        ];
                        $selectedDept = old('department', $employee->department ?? '');
                    @endphp
                    @foreach($departments as $key => $label)
                        <option value="{{ $key }}" {{ $selectedDept === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('department')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="position">Position / Role: <span style="color:#dc2626">*</span></label>
                <select name="position" id="position" required>
                    <option value="">-- Select Position --</option>
                    @php
                        $positions = [
                            'Branch Manager'          => 'Branch Manager',
                            'Loan Officer'            => 'Loan Officer',
                            'Senior Loan Officer'     => 'Senior Loan Officer',
                            'Cashier'                 => 'Cashier / Teller',
                            'Accountant'              => 'Accountant',
                            'Customer Service Officer'=> 'Customer Service Officer',
                            'IT Support'              => 'IT Support',
                            'Security'                => 'Security',
                        ];
                        $selectedPos = old('position', $employee->position ?? $employee->role ?? '');
                    @endphp
                    @foreach($positions as $key => $label)
                        <option value="{{ $key }}" {{ $selectedPos === $key ? 'selected' : '' }}>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
                @error('position')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
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
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address', $employee->address) }}" required>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active" {{ old('status', strtolower($employee->status)) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', strtolower($employee->status)) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Terminated" {{ old('status', strtolower($employee->status)) == 'terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="Resigned" {{ old('status', strtolower($employee->status)) == 'resigned' ? 'selected' : '' }}>Resigned</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label for="profile_picture">Profile Picture</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*" class="btn">
                @error('profile_picture')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                @if ($employee->profile_picture)
                    <div style="margin-bottom:6px">
                        <img src="{{asset('storage/' .$employee->profile_picture)}}" alt="Current Photo" style="height:100px; border-radius:5px">
                        <span style="margin-left:8px; font-size:0.8rem; color:#555">Current Photo</span>
                    </div>
                @endif
            </div>
        </div>

        <div class="action">
            <button type="submit" class="btn btn-primary">Update Employee</button>
            <a href="{{ route('employees.index')}}" style="margin-left: 12px" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection