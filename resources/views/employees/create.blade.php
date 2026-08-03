@extends('layouts.app')
@section('title', 'Create Employee')
@section('main')
        <h1>Create Employee</h1>
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
        <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name') }}" required>
                @error('first_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name') }}" required>
                @error('last_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="position">Position:</label>
                <input type="text" id="position" name="position" value="{{ old('position') }}" required>
                @error('position')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="department">Department:</label>
                <input type="text" id="department" name="department" value="{{ old('department') }}" required>
                @error('department')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone') }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" id="address" name="address" value="{{ old('address') }}" required>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="hiring_date">Hire Date:</label>
                <input type="date" id="hiring_date" name="hiring_date" value="{{ old('hiring_date') }}" required>
                @error('hiring_date')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="salary">Salary:</label>
                <input type="number" id="salary" name="salary" value="{{ old('salary') }}" step="0.01" required>
                @error('salary')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active" {{ old('status','Active') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status','Inactive') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                    <option value="Terminated" {{ old('status','Terminated') == 'Terminated' ? 'selected' : '' }}>Terminated</option>
                    <option value="Resigned" {{ old('status','Resigned') == 'Resigned' ? 'selected' : '' }}>Resigned</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="profile_picture">Profile Picture:</label>
                <input type="file" id="profile_picture" name="profile_picture" accept="image/*">
                @error('profile_picture')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="action">
                <button type="submit" class="btn btn-primary">Create Employee</button>
                <a href="{{ route('employees.index')}}" style="margin-left: 12px" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
@endsection