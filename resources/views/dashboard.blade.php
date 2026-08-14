@extends('layouts.app')
@section('title', 'Dashboard')
@section('main')
    <h1>Dashboard</h1>
    <form action="{{route('logout')}}" method="POST">
        @csrf
        <button type="submit" class="btn btn-danger">Logout</button>
    </form>
@endsection