@extends('layouts.app')
@section('title', 'Category Details')
@section('content')
<h1>Category Details</h1>

<div class="card">
    <div class="row">
        <div class="label">Category Name:</div>
        <div class="value">{{ $category->name }}</div>
    </div>
    
    <div class="row">
        <div class="label">Description:</div>
        <div class="value">{{ $category->description ?? 'No description provided.' }}</div>
    </div>
    
    <div class="actions">
        <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning">Edit</a>
        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back to List</a>
    </div>
</div>

@endsection