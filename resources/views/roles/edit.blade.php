@extends('layouts.app')

@section('content')

<div class="container">


<div class="card shadow">


<div class="card-header bg-warning">

<h3>
Edit Role
</h3>

</div>



<div class="card-body">


<form method="POST"
action="{{route('roles.update',$role)}}">


@csrf

@method('PUT')


<div class="mb-3">


<label>
Role Name
</label>


<input
type="text"
name="name"
value="{{$role->name}}"
class="form-control">


</div>



<button class="btn btn-primary">

Update

</button>


</form>


</div>


</div>


</div>


@endsection