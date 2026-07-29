<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <title>Register</title>
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
    <h1>Register</h1>
    <form action="{{route('register')}}" method="POST" novalidate autocomplete="off">
        @csrf
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" value="{{ old('email') }}" required>
            @error('email')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>
            @error('password')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password_confirmation">Confirm Password:</label>
            <input type="password" name="password_confirmation" id="password_confirmation" required>
            @error('password_confirmation')
                <span class="error">{{ $message }}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="remember">Remember Me:</label>
            <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
        </div>

        <div class="action">
            <button type="submit" class="btn btn-primary">Register</button>
            <a href="{{route('login')}}" class="btn btn-secondary">Login</a>
        </div>
    </form>
</body>
</html>