@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-warning">

<h3>Edit Category</h3>

</div>

<div class="card-body">

<form action="{{ route('categories.update',$category) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Category Name</label>

<input
type="text"
name="name"
value="{{ old('name',$category->name) }}"
class="form-control"
required>

</div>

<button class="btn btn-primary">

Update Category

</button>

<a href="{{ route('categories.index') }}"
class="btn btn-secondary">

Cancel

</a>

</form>

</div>

</div>

</div>

@endsection