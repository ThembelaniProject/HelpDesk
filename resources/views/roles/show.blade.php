@extends('layouts.app')

@section('content')


<div class="container">


<div class="card">


<div class="card-header">

Role Details

</div>


<div class="card-body">


<h4>
{{$role->name}}
</h4>


<p>

Users assigned:

{{$role->users()->count()}}

</p>



<a href="{{route('roles.index')}}"
class="btn btn-primary">

Back

</a>


</div>


</div>


</div>


@endsection