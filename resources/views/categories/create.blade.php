@extends('layouts.app')
@section('title', 'Create Category')
@section('main')
    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description"></textarea>
        </div>
        <button class="btn btn-primary" type="submit">Create Category</button>
    </form>
@endsection