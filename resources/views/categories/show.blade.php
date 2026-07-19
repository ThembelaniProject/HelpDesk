@extends('layouts.app')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header">

<h3>Category Details</h3>

</div>

<div class="card-body">

<p><strong>ID:</strong> {{ $category->id }}</p>

<p><strong>Name:</strong> {{ $category->name }}</p>

<p><strong>Total Tickets:</strong> {{ $category->tickets()->count() }}</p>

<a href="{{ route('categories.index') }}"
class="btn btn-primary">

Back

</a>

</div>

</div>

</div>

@endsection