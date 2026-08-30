@extends('layouts.app')
@section('title', 'Edit Customer')
@section('content')
<div class="form-container">
    <h1>Edit Customer</h1>
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

    <form action="{{ route('customers.update', $customer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-row">
            <div class="form-group">
                <label for="customer_code">Customer Code <span style="color:red">*</span></label>
                <input type="text" id="customer_code" name="customer_code" value="{{ old('customer_code', $customer->customer_code) }}" readonly style="background-color: #f1f5f9; color: #64748b; cursor: not-allowed;">
                @error('customer_code')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Status <span style="color:red">*</span></label>
                <select id="status" name="status" required>
                    <option value="Active" {{ old('status',$customer->status,'Active') == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status',$customer->status,'Inactive') == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="first_name">First Name <span style="color:red">*</span></label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required>
                @error('first_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="last_name">Last Name <span style="color:red">*</span></label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required>
                @error('last_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="gender">Gender <span style="color:red">*</span></label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender', strtolower($customer->gender)) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', strtolower($customer->gender)) == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="date_of_birth">Date of Birth</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}">
                @error('date_of_birth')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="form-row">
            <div class="form-group">
                <label for="phone">Phone <span style="color:red">*</span></label>
                <input type="number" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Email <span style="color:red">*</span></label>
                <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City / Province: <span style="color:#dc2626">*</span></label>
                <select name="city" id="city" required>
                    <option value="">-- Select City / Province --</option>
                    @php
                        $provinces = [
                            'Phnom Penh', 'Kandal', 'Siem Reap', 'Battambang', 'Kampong Cham',
                            'Kampong Chhnang', 'Kampong Speu', 'Kampong Thom', 'Kampot', 'Kep',
                            'Koh Kong', 'Kratie', 'Mondulkiri', 'Oddar Meanchey', 'Pailin',
                            'Preah Sihanouk', 'Preah Vihear', 'Prey Veng', 'Pursat', 'Ratanakiri',
                            'Stung Treng', 'Svay Rieng', 'Takeo', 'Tboung Khmum', 'Banteay Meanchey'
                        ];
                        $selectedCity = old('city', $customer->city ?? '');
                    @endphp
                    @foreach($provinces as $province)
                        <option value="{{ $province }}" {{ $selectedCity === $province ? 'selected' : '' }}>
                            {{ $province }}
                        </option>
                    @endforeach
                </select>
                @error('city')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address <span style="color:red">*</span></label>
                <textarea id="address" name="address" required>{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
        </div>

        <div class="action">
            <button class="btn btn-primary" type="submit">Update Customer</button>
            <a href="{{ route('customers.index') }}" class="btn btn-secondary" style="margin-left: 12px">Cancel</a>
        </div>
    </form>
</div>
@endsection