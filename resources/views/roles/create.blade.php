@extends('layouts.app')

@section('content')


<div class="container">


<div class="card shadow">


<div class="card-header bg-success text-white">

<h3>
Create Role
</h3>

</div>



<div class="card-body">


<form method="POST"
action="{{route('roles.store')}}">


@csrf



<div class="mb-3">


<label>
Role Name
</label>


<input
type="text"
name="name"
class="form-control"
placeholder="Admin">


</div>



<button class="btn btn-success">

Save Role

</button>


<a href="{{route('roles.index')}}"
class="btn btn-secondary">

Cancel

</a>


</form>


</div>


</div>


</div>


@endsection