@extends('layouts.app')
@section('title', 'Edit Category')
@section('content')
    <h1>Edit Category</h1>
    <form action="{{ route('categories.update', $category->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $category->name }}" required>
        </div>
        <div>
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ $category->description }}</textarea>
        </div>
        <button class="btn btn-primary" type="submit">Update Category</button>
        <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
    </form>
@endsection