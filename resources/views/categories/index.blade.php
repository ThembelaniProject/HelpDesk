@extends('layouts.app')

@section('content')

<div class="container">

<div class="d-flex justify-content-between mb-3">

<h2>Categories</h2>

<a href="{{ route('categories.create') }}" class="btn btn-primary">
    Add Category
</a>

</div>

@if(session('success'))
<div class="alert alert-success">
    {{ session('success') }}
</div>
@endif

<div class="card shadow">

<div class="table-responsive">

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Name</th>

<th>Tickets</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

@forelse($categories as $category)

<tr>

<td>{{ $category->id }}</td>

<td>{{ $category->name }}</td>

<td>{{ $category->tickets_count }}</td>

<td>

<a href="{{ route('categories.edit',$category) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form action="{{ route('categories.destroy',$category) }}"
method="POST"
class="d-inline">

@csrf
@method('DELETE')

<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete this category?')">

Delete

</button>

</form>

</td>

</tr>

@empty

<tr>

<td colspan="4" class="text-center">

No categories found.

</td>

</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="mt-3">
{{ $categories->links() }}
</div>

</div>

@endsection