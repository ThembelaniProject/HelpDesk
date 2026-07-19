@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <h2 class="mb-4">
        Reports Dashboard
    </h2>

    {{-- KPI CARDS --}}

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-primary shadow">
                <div class="card-body text-center">
                    <h6>Total Tickets</h6>
                    <h2>{{ $totalTickets }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-success shadow">
                <div class="card-body text-center">
                    <h6>Resolved</h6>
                    <h2>{{ $resolvedTickets }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-warning shadow">
                <div class="card-body text-center">
                    <h6>In Progress</h6>
                    <h2>{{ $progressTickets }}</h2>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-danger shadow">
                <div class="card-body text-center">
                    <h6>Open</h6>
                    <h2>{{ $openTickets }}</h2>
                </div>
            </div>
        </div>

    </div>

    {{-- FILTERS --}}

    <div class="card mb-4">

        <div class="card-header">

            Filter Reports

        </div>

        <div class="card-body">

            <form method="GET">

                <div class="row">

                    <div class="col-md-2">

                        <select
                            name="status"
                            class="form-select">

                            <option value="">All Status</option>

                            <option value="Open">Open</option>
                            <option value="Assigned">Assigned</option>
                            <option value="In Progress">In Progress</option>
                            <option value="Resolved">Resolved</option>
                            <option value="Closed">Closed</option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="priority"
                            class="form-select">

                            <option value="">
                                All Priority
                            </option>

                            <option>Low</option>
                            <option>Medium</option>
                            <option>High</option>
                            <option>Critical</option>

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="category"
                            class="form-select">

                            <option value="">
                                All Categories
                            </option>

                            @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}">

                                {{ $category->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <select
                            name="technician"
                            class="form-select">

                            <option value="">
                                All Technicians
                            </option>

                            @foreach($technicians as $tech)

                            <option
                                value="{{ $tech->id }}">

                                {{ $tech->name }}

                            </option>

                            @endforeach

                        </select>

                    </div>

                    <div class="col-md-2">

                        <input
                            type="date"
                            name="from"
                            class="form-control">

                    </div>

                    <div class="col-md-2">

                        <input
                            type="date"
                            name="to"
                            class="form-control">

                    </div>

                </div>

                <br>

                <button
                    class="btn btn-primary">

                    Filter

                </button>

                <a
                    href="{{ route('reports.index') }}"
                    class="btn btn-secondary">

                    Reset

                </a>

            </form>

        </div>

    </div>

    {{-- EXPORT BUTTONS --}}

    <div class="mb-3">

        <a
            href="{{ route('reports.pdf') }}"
            class="btn btn-danger">

            Export PDF

        </a>

        <a
            href="{{ route('reports.excel') }}"
            class="btn btn-success">

            Export Excel

        </a>

    </div>

    {{-- CHARTS --}}

    <div class="row">

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header">

                    Ticket Status

                </div>

                <div class="card-body">

                    <canvas id="statusChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header">

                    Priority

                </div>

                <div class="card-body">

                    <canvas id="priorityChart"></canvas>

                </div>

            </div>

        </div>

        <div class="col-md-4">

            <div class="card shadow">

                <div class="card-header">

                    Monthly Tickets

                </div>

                <div class="card-body">

                    <canvas id="monthlyChart"></canvas>

                </div>

            </div>

        </div>

    </div>

    <br>

    {{-- TABLE --}}

    <div class="card">

        <div class="card-header">

            Ticket Report

        </div>

        <div class="card-body">

            <table class="table table-bordered table-striped">

                <thead>

                    <tr>

                        <th>ID</th>
                        <th>Title</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Category</th>
                        <th>User</th>
                        <th>Technician</th>
                        <th>Date</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($tickets as $ticket)

                    <tr>

                        <td>{{ $ticket->id }}</td>

                        <td>{{ $ticket->title }}</td>

                        <td>{{ $ticket->status }}</td>

                        <td>{{ $ticket->priority }}</td>

                        <td>{{ $ticket->category->name }}</td>

                        <td>{{ $ticket->user->name }}</td>

                        <td>{{ $ticket->technician->name ?? '-' }}</td>

                        <td>{{ $ticket->created_at->format('d M Y') }}</td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $tickets->links() }}

        </div>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

new Chart(document.getElementById('statusChart'),{

type:'pie',

data:{

labels:[
'Open',
'Assigned',
'In Progress',
'Resolved',
'Closed'
],

datasets:[{

data:@json($statusData)

}]

}

});

new Chart(document.getElementById('priorityChart'),{

type:'bar',

data:{

labels:[
'Low',
'Medium',
'High',
'Critical'
],

datasets:[{

label:'Tickets',

data:@json($priorityData)

}]

}

});

new Chart(document.getElementById('monthlyChart'),{

type:'line',

data:{

labels:[
'Jan',
'Feb',
'Mar',
'Apr',
'May',
'Jun',
'Jul',
'Aug',
'Sep',
'Oct',
'Nov',
'Dec'
],

datasets:[{

label:'Tickets',

data:@json($monthlyData),

fill:false,

tension:.4

}]

}

});

</script>

@endsection