<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Cash Loan Management') }}</title>

    {{-- Bootstrap Icons --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    {{-- Dedicated Auth Stylesheet --}}
    <link rel="stylesheet" href="{{ asset('assets/css/bladeStyle/auth.css') }}">
</head>
<body>
    <main class="w-100">
        @yield('content')
        {{ $slot ?? '' }}
    </main>
</body>
</html>