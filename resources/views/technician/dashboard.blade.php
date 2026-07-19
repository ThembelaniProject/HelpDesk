@extends('layouts.app')


@section('content')


<div class="container">


<h2>
Technician Dashboard
</h2>



<div class="card shadow mt-4">


<div class="card-header">

My Assigned Tickets

</div>



<table class="table">


<thead class="table-dark">


<tr>

<th>
Title
</th>

<th>
Priority
</th>

<th>
Status
</th>

<th>
Action
</th>


</tr>


</thead>



<tbody>


@foreach($tickets as $ticket)


<tr>


<td>

{{$ticket->title}}

</td>


<td>

{{$ticket->priority}}

</td>


<td>

<span class="badge bg-info">

{{$ticket->status}}

</span>

</td>


<td>


<a href="{{route('tickets.show',$ticket)}}"
class="btn btn-primary btn-sm">

View

</a>


</td>


</tr>


@endforeach


</tbody>


</table>


</div>


</div>


@endsection