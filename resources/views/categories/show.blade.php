@extends('layouts.app')
@section('title', 'Category Details')
@section('main')
    <h1>Category Details</h1>
    <p><strong>Name:</strong> {{ $category->name }}</p>
    <p><strong>Description:</strong> {{ $category->description }}</p>
    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-primary">Edit</a>
    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
    <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to Categories</a>
@endsection