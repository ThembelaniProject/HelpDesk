@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h3>Create Category</h3>

</div>

<div class="card-body">

<form action="{{ route('categories.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Category Name</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<button class="btn btn-success">

Save Category

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