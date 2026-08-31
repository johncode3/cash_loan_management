@extends('layouts.app')
@section('title', 'Create Category')
@section('content')
<div class="form-container">
    <h1>Create Category</h1>

    @if ($errors->any())
        <div style="border:1px solid #f5c6cb; background:#f8d7da; padding:10px; margin-bottom:16px; border-radius:6px">
            <ul style="margin: 0 0 0 20px; color: #991b1b">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('categories.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="name">Name: <span style="color:#dc2626">*</span></label>
            <input type="text" name="name" id="name" value="{{ old('name') }}" required>
            @error('name')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="description">Description:</label>
            <textarea name="description" id="description">{{ old('description') }}</textarea>
            @error('description')
                <div class="error">{{ $message }}</div>
            @enderror
        </div>

        <div class="action">
            <a href="{{ route('categories.index') }}" class="btn btn-danger"><i class="bi bi-x-circle"></i> Cancel</a>
            <button class="btn btn-primary" type="submit"><i class="bi bi-plus-circle"></i> Create Category</button>
        </div>
    </form>
</div>
@endsection