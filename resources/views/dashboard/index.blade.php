
@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row g-4">

        <div class="col-md-3">

            <div class="card bg-primary text-white">

                <div class="card-body">

                    <h6>Total Tickets</h6>

                    <h2>{{ $totalTickets }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-success text-white">

                <div class="card-body">

                    <h6>Resolved</h6>

                    <h2>{{ $resolvedTickets }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-warning text-dark">

                <div class="card-body">

                    <h6>Open</h6>

                    <h2>{{ $openTickets }}</h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-danger text-white">

                <div class="card-body">

                    <h6>Critical</h6>

                    <h2>{{ $criticalTickets }}</h2>

                </div>

            </div>

        </div>

    </div>

    <div class="row mt-4">

        <div class="col-lg-8">

            <div class="card shadow">

                <div class="card-header">

                    Ticket Statistics

                </div>

                <div class="card-body">

                    <canvas id="ticketChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-lg-4">

            <div class="card shadow">

                <div class="card-header">

                    System Statistics

                </div>

                <div class="card-body">

                    <table class="table table-bordered">

                        <tr>

                            <th>Total Users</th>

                            <td>{{ $totalUsers }}</td>

                        </tr>

                        <tr>

                            <th>Categories</th>

                            <td>{{ $categories }}</td>

                        </tr>

                        <tr>

                            <th>Assigned</th>

                            <td>{{ $assignedTickets }}</td>

                        </tr>

                        <tr>

                            <th>In Progress</th>

                            <td>{{ $progressTickets }}</td>

                        </tr>

                        <tr>

                            <th>Closed</th>

                            <td>{{ $closedTickets }}</td>

                        </tr>

                    </table>

                </div>

            </div>

        </div>

    </div>

    <div class="card shadow mt-4">

        <div class="card-header">

            Recent Tickets

        </div>

        <div class="table-responsive">

            <table class="table table-hover">

                <thead class="table-dark">

                    <tr>

                        <th>ID</th>

                        <th>Title</th>

                        <th>Status</th>

                        <th>Priority</th>

                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($recentTickets as $ticket)

                        <tr>

                            <td>{{ $ticket->id }}</td>

                            <td>{{ $ticket->title }}</td>

                            <td>{{ $ticket->status }}</td>

                            <td>{{ $ticket->priority }}</td>

                            <td>{{ $ticket->created_at->format('d M Y') }}</td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="text-center">

                                No tickets found.

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>

const ctx = document.getElementById('ticketChart');

new Chart(ctx, {

    type: 'doughnut',

    data: {

        labels: [

            'Open',

            'Assigned',

            'In Progress',

            'Resolved',

            'Closed'

        ],

        datasets: [{

            label: 'Tickets',

            data: [

                {{ $openTickets }},

                {{ $assignedTickets }},

                {{ $progressTickets }},

                {{ $resolvedTickets  }},

                {{ $closedTickets }}

            ]

        }]

    },

    options: {

        responsive: true,

        plugins: {

            legend: {

                position: 'bottom'

            }

        }

    }

});

</script>
<div class="card mt-4">

<div class="card-header">

Top Technicians

</div>

<div class="card-body">

<table class="table">

<thead>

<tr>

<th>Name</th>

<th>Assigned Tickets</th>

</tr>

</thead>

<tbody>

@forelse($topTechnicians as $tech)
<tr>
    <td>{{ $tech->name }}</td>
    <td>{{ $tech->assigned_tickets_count }}</td>
</tr>

@empty

<tr>
    <td colspan="2" class="text-center">
        No technicians found.
    </td>
</tr>

@endforelse


</tbody>

</table>

</div>

</div>

<div class="card mt-4">

<div class="card-header">

Tickets by Category

</div>

<div class="card-body">

<table class="table">

<thead>

<tr>

<th>Category</th>

<th>Total Tickets</th>

</tr>

</thead>

<tbody>

@forelse($categoryStats as $category)

<tr>
    <td>{{ $category->name }}</td>
    <td>{{ $category->tickets_count }}</td>
</tr>

@empty

<tr>
    <td colspan="2" class="text-center">
        No categories found.
    </td>
</tr>

@endforelse

</tbody>

</table>

</div>

</div>

<div class="card mt-4">

<div class="card-header">

Performance

</div>

<div class="card-body">

<h3>

{{ number_format($avgResolution ?? 0, 1) }}

Hours

</h3>

<p>

Average Resolution Time

</p>

</div>

</div>


@endsection
