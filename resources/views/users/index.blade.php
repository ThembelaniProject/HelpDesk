@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between mb-4">

<h2>

Users

</h2>

<a href="{{ route('users.create') }}"
class="btn btn-primary">

New User

</a>

</div>

<div class="card">

<div class="table-responsive">

<table class="table table-hover">

<thead class="table-dark">

<tr>

<th>ID</th>

<th>Name</th>

<th>Email</th>

<th>Role</th>

<th>Actions</th>

</tr>

</thead>

<tbody>

@foreach($users as $user)

<tr>

<td>{{ $user->id }}</td>

<td>{{ $user->name }}</td>

<td>{{ $user->email }}</td>

<td>{{ $user->role->name ?? '-' }}</td>

<td>

<a
href="{{ route('users.edit',$user) }}"
class="btn btn-warning btn-sm">

Edit

</a>

<form
method="POST"
action="{{ route('users.destroy',$user) }}"
class="d-inline">

@csrf

@method('DELETE')

<button class="btn btn-danger btn-sm">

Delete

</button>

</form>

</td>

</tr>

@endforeach

</tbody>

</table>

</div>

</div>

@endsection