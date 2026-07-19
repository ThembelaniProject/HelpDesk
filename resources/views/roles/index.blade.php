@extends('layouts.app')

@section('content')

<div class="container">


<div class="d-flex justify-content-between mb-3">

<h2>
Roles
</h2>


<a href="{{route('roles.create')}}"
class="btn btn-primary">

Add Role

</a>


</div>



@if(session('success'))

<div class="alert alert-success">

{{session('success')}}

</div>

@endif



@if(session('error'))

<div class="alert alert-danger">

{{session('error')}}

</div>

@endif



<div class="card shadow">


<table class="table table-hover">


<thead class="table-dark">

<tr>

<th>ID</th>

<th>Role Name</th>

<th>Users</th>

<th>Actions</th>

</tr>

</thead>



<tbody>


@foreach($roles as $role)


<tr>


<td>
{{$role->id}}
</td>


<td>
{{$role->name}}
</td>


<td>
{{$role->users_count}}
</td>


<td>


<a href="{{route('roles.edit',$role)}}"
class="btn btn-warning btn-sm">

Edit

</a>



<form action="{{route('roles.destroy',$role)}}"
method="POST"
class="d-inline">


@csrf

@method('DELETE')


<button class="btn btn-danger btn-sm"
onclick="return confirm('Delete role?')">

Delete

</button>


</form>


</td>


</tr>


@endforeach


</tbody>


</table>


</div>


{{$roles->links()}}


</div>


@endsection