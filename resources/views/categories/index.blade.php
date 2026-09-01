@extends('layouts.app')
@section('title', 'Category List')
@section('content')
<h1>Category List</h1>
@if (session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="toolbar">
    <a href="{{ route('categories.create') }}" class="btn btn-primary"><i class="bi bi-plus-circle"></i> Create New Category</a>
</div>
<form action="{{ route('categories.index') }}" method="GET" class="filter-bar">
    <div>
        <label for="search">Search Category</label>
        <input type="text" name="search" id="liveSearch" value="{{ request('search') }}" placeholder="Search by name...">
    </div>
    <div>
        <label>&nbsp;</label>
        <a href="{{ route('categories.index') }}" class="btn btn-danger"><i class="bi bi-x-circle"></i> Clear</a>
    </div>
</form>
<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($categories as $category)
            <tr>
                <td>{{ $category->name }}</td>
                <td>{{ $category->description }}</td>
                <td>
                    <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning"><i class="bi bi-pencil"></i></a>
                    <a href="{{ route('categories.show', $category->id)}}" class="btn btn-info"><i class="bi bi-eye"></i></a>
                    <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this category?');" >
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" type="submit"><i class="bi bi-trash"></i></button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection