<!DOCTYPE html>
<html lang={{str_replace('_', '-', app()->getLocale())}}>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard</title>
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
    <h1>Dashboard</h1>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
</body>
</html>