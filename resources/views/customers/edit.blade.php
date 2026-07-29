<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            padding: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: 600;
        }
        input [type="text"], input[type="email"], input[type="number"] {
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-top: 5px;
        }
        .action {
            margin-top: 20px;
        }
        .btn{
            display:inline-block;
            padding: 5px 10px;
            border-radius: 4px;
            font-size:0.82rem;
            text-decoration:none;
            cursor:pointer;
            border: none;
            font-family: inherit
        }
        .btn-primary{
            background:#2563eb;
            color:#fff
        }
        .btn-secondary {
            background: #6b7280;
            color: #fff
        }
        .btn-warning {
            background:#d97706;
            color:#fff
        }
        .btn-info {
            background: #0891b2;
            color:#fff
        }
        .btn-danger {
            background:#dc2626;
            color:#fff
        }
        .btn:hover{
            opacity:0.85
        }
    </style>
    </head>
    <body>
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

            <div class="form-group">
                <label for="customer_code">Customer Code:</label>
                <input type="text" id="customer_code" name="customer_code" value="{{ old('customer_code', $customer->customer_code) }}" required>
                @error('customer_code')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="first_name">First Name:</label>
                <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $customer->first_name) }}" required>
                @error('first_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="last_name">Last Name:</label>
                <input type="text" id="last_name" name="last_name" value="{{ old('last_name', $customer->last_name) }}" required>
                @error('last_name')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="gender">Gender:</label>
                <select id="gender" name="gender" required>
                    <option value="">Select Gender</option>
                    <option value="Male" {{ old('gender', $customer->gender) == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('gender', $customer->gender) == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('gender')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="date_of_birth">Date of Birth:</label>
                <input type="date" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $customer->date_of_birth) }}" required>
                @error('date_of_birth')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="phone">Phone:</label>
                <input type="number" id="phone" name="phone" value="{{ old('phone', $customer->phone) }}" required>
                @error('phone')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="{{ old('email', $customer->email) }}" required>
                @error('email')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <textarea id="address" name="address" required>{{ old('address', $customer->address) }}</textarea>
                @error('address')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="city">City:</label>
                <input type="text" id="city" name="city" value="{{ old('city', $customer->city) }}" required>
                @error('city')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="status">Status:</label>
                <select id="status" name="status" required>
                    <option value="Active" {{ old('status', $customer->status) == 'Active' ? 'selected' : '' }}>Active</option>
                    <option value="Inactive" {{ old('status', $customer->status) == 'Inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>
            
            <div class="action">
                <button class="btn btn-primary" type="submit">Update Customer</button>
                <a href="{{ route('customers.index')}}" style="margin-left: 12px" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </body>
</html>