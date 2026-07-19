@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-ticket-detailed-fill"></i>
            Ticket Management
        </h2>

        <a href="{{ route('tickets.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i>
            Create Ticket
        </a>

    </div>

    @if(session('success'))

        <div class="alert alert-success">

            {{ session('success') }}

        </div>

    @endif

    <div class="card mb-4">

        <div class="card-body">

            <form method="GET" action="{{ route('tickets.index') }}">

               <div class="row g-3">

    <!-- Search -->
    <div class="col-lg-5 col-md-12">

        <label class="form-label fw-bold">
            Search Ticket
        </label>

        <input
            type="text"
            name="search"
            class="form-control"
            placeholder="Search by title or description..."
            value="{{ request('search') }}"
        >

    </div>

    <!-- Status -->
    <div class="col-lg-3 col-md-6">

        <label class="form-label fw-bold">
            Status
        </label>

        <select name="status" class="form-select">

            <option value="">All Status</option>

            <option value="Open" @selected(request('status')=='Open')>
                Open
            </option>

            <option value="Assigned" @selected(request('status')=='Assigned')>
                Assigned
            </option>

            <option value="In Progress" @selected(request('status')=='In Progress')>
                In Progress
            </option>

            <option value="Resolved" @selected(request('status')=='Resolved')>
                Resolved
            </option>

            <option value="Closed" @selected(request('status')=='Closed')>
                Closed
            </option>

        </select>

    </div>

    <!-- Sort -->
    <div class="col-lg-3 col-md-6">

        <label class="form-label fw-bold">
            Sort
        </label>

        <select name="sort" class="form-select">

            <option value="latest"
                @selected(request('sort')=='latest')>

                Latest First

            </option>

            <option value="oldest"
                @selected(request('sort')=='oldest')>

                Oldest First

            </option>

        </select>

    </div>

    <!-- Empty spacing -->
    <div class="col-lg-1 d-none d-lg-block"></div>

    <!-- Buttons -->
    <div class="col-md-6">

        <button class="btn btn-success w-100">

            <i class="bi bi-search"></i>

            Search

        </button>

    </div>

    <div class="col-md-6">

        <a href="{{ route('tickets.index') }}"
           class="btn btn-outline-secondary w-100">

            <i class="bi bi-arrow-clockwise"></i>

            Reset

        </a>

    </div>

</div>

            </form>

        </div>

    </div>

    <div class="card">

        <div class="table-responsive">

            <table class="table table-hover align-middle">

                <thead class="table-dark">

                <tr>

                    <th>ID</th>

                    <th>Title</th>

                    <th>Category</th>

                    <th>Priority</th>

                    <th>SLA</th>

                    <th>Status</th>

                    <th>Created By</th>

                    <th>Technician</th>

                    <th>Actions</th>

                </tr>

                </thead>

                <tbody>

                @forelse($tickets as $ticket)

                    <tr>

                        <td>{{ $ticket->id }}</td>

                        <td>{{ $ticket->title }}</td>

                        <td>{{ $ticket->category->name ?? '-' }}</td>

                        <td>

                            @if($ticket->priority=='Critical')

                                <span class="badge bg-danger">

                            @elseif($ticket->priority=='High')

                                <span class="badge bg-warning text-dark">

                            @elseif($ticket->priority=='Medium')

                                <span class="badge bg-primary">

                            @else

                                <span class="badge bg-success">

                            @endif

                                {{ $ticket->priority }}

                            </span>

                        </td>
                        <td>

@if($ticket->status=="Resolved")

    @if($ticket->sla_breached)

        <span class="badge bg-danger">
            Breached
        </span>

    @else

        <span class="badge bg-success">
            Met
        </span>

    @endif

@elseif($ticket->due_date && now()->greaterThan($ticket->due_date))

    <span class="badge bg-danger">
        Overdue
    </span>

@elseif($ticket->due_date && now()->diffInHours($ticket->due_date,false)<=4)

    <span class="badge bg-warning">
        Due Soon
    </span>

@else

    <span class="badge bg-primary">
        Active
    </span>

@endif

</td>

                        <td>

                            @switch($ticket->status)

                                @case('Open')

                                    <span class="badge bg-primary">

                                    @break

                                @case('Assigned')

                                    <span class="badge bg-warning text-dark">

                                    @break

                                @case('In Progress')

                                    <span class="badge bg-info text-dark">

                                    @break

                                @case('Resolved')

                                    <span class="badge bg-success">

                                    @break

                                @default

                                    <span class="badge bg-dark">

                            @endswitch

                            {{ $ticket->status }}

                            </span>

                        </td>

                        <td>

                            {{ $ticket->user->name ?? '-' }}

                        </td>

                        <td>

                            {{ $ticket->technician->name ?? 'Not Assigned' }}

                        </td>

                        <td>

    <a href="{{ route('tickets.show',$ticket) }}" class="btn btn-info btn-sm">
        <i class="bi bi-eye"></i>
    </a>

    @if(auth()->user()->role->name == 'Admin')

        <a href="{{ route('tickets.edit',$ticket) }}" class="btn btn-warning btn-sm">
            <i class="bi bi-pencil"></i>
        </a>

        <form action="{{ route('tickets.destroy',$ticket) }}"
              method="POST"
              class="d-inline">

            @csrf
            @method('DELETE')

            <button
                class="btn btn-danger btn-sm"
                onclick="return confirm('Delete this ticket?')">

                <i class="bi bi-trash"></i>

            </button>

        </form>

    @endif

</td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="8" class="text-center">

                            No Tickets Found

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="mt-3">

       {{ $tickets->appends(request()->query())->links() }}

    </div>

</div>

@endsection