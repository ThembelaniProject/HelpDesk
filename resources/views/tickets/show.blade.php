@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between mb-4">
        <h2>Ticket #{{ $ticket->id }}</h2>

        <a href="{{ route('tickets.index') }}" class="btn btn-secondary">
            Back
        </a>
    </div>

    <div class="row">

        {{-- LEFT SIDE --}}
        <div class="col-lg-8">

            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    Ticket Information
                </div>

                <div class="card-body">

                    <table class="table">

                        <tr>
                            <th width="180">Title</th>
                            <td>{{ $ticket->title }}</td>
                        </tr>

                        <tr>
                            <th>Description</th>
                            <td>{{ $ticket->description }}</td>
                        </tr>

                        <tr>
                            <th>Category</th>
                            <td>{{ $ticket->category->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Priority</th>
                            <td>

                                @switch($ticket->priority)

                                    @case('Critical')
                                        <span class="badge bg-danger">Critical</span>
                                        @break

                                    @case('High')
                                        <span class="badge bg-warning text-dark">High</span>
                                        @break

                                    @case('Medium')
                                        <span class="badge bg-primary">Medium</span>
                                        @break

                                    @default
                                        <span class="badge bg-success">Low</span>

                                @endswitch

                            </td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
                                <span class="badge bg-info">
                                    {{ $ticket->status }}
                                </span>
                            </td>
                        </tr>

                        <tr>
                            <th>Created By</th>
                            <td>{{ $ticket->user->name }}</td>
                        </tr>

                        <tr>
                            <th>Assigned Technician</th>
                            <td>{{ $ticket->technician->name ?? 'Not Assigned' }}</td>
                        </tr>

                        <tr>
                            <th>Created</th>
                            <td>{{ $ticket->created_at->format('d M Y H:i') }}</td>
                        </tr>

                    </table>

                </div>
            </div>


            {{-- COMMENTS --}}
            <div class="card">

                <div class="card-header">
                    Comments
                </div>

                <div class="card-body">

                    @forelse($ticket->comments as $comment)

                        <div class="border rounded p-3 mb-3">

                            <strong>{{ $comment->user->name }}</strong>

                            <br>

                            <small class="text-muted">
                                {{ $comment->created_at->diffForHumans() }}
                            </small>

                            <hr>

                            {{ $comment->comment }}

                        </div>

                    @empty

                        <div class="alert alert-info">
                            No comments yet.
                        </div>

                    @endforelse

                </div>

            </div>

        </div>



        {{-- RIGHT SIDE --}}
        <div class="col-lg-4">

            {{-- ADD COMMENT --}}
            <div class="card mb-4">

                <div class="card-header">
                    Add Comment
                </div>

                <div class="card-body">

                    <form action="{{ route('comments.store') }}" method="POST">

                        @csrf

                        <input
                            type="hidden"
                            name="ticket_id"
                            value="{{ $ticket->id }}">

                        <textarea
                            name="comment"
                            rows="5"
                            class="form-control mb-3"
                            required></textarea>

                        <button class="btn btn-success w-100">
                            Add Comment
                        </button>

                    </form>

                </div>

            </div>


            {{-- ATTACHMENTS --}}
            <div class="card mb-4">

                <div class="card-header bg-secondary text-white">
                    File Attachments
                </div>

                <div class="card-body">

                    <form action="{{ route('attachments.store',$ticket) }}"
                          method="POST"
                          enctype="multipart/form-data">

                        @csrf

                        <input
                            type="file"
                            name="file"
                            class="form-control mb-3"
                            required>

                        <button class="btn btn-primary w-100">
                            Upload File
                        </button>

                    </form>

                    <hr>

                    @forelse($ticket->attachments as $attachment)

                        <div class="d-flex justify-content-between align-items-center mb-2">

                            <div>
                                <i class="bi bi-paperclip"></i>

                                {{ $attachment->filename }}

                                <br>

                                <small class="text-muted">

                                    {{ number_format($attachment->filesize/1024,2) }} KB

                                </small>

                            </div>

                            <div>

                                <a href="{{ route('attachments.download',$attachment) }}"
                                   class="btn btn-success btn-sm">

                                    Download

                                </a>

                                <form
                                    action="{{ route('attachments.destroy',$attachment) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-danger btn-sm">

                                        Delete

                                    </button>

                                </form>

                            </div>

                        </div>

                    @empty

                        <div class="alert alert-info">
                            No attachments uploaded.
                        </div>

                    @endforelse

                </div>

            </div>


            {{-- ASSIGN TECHNICIAN --}}
        {{-- ASSIGN TECHNICIAN (ADMIN ONLY) --}}
@if(auth()->check() && auth()->user()->role && auth()->user()->role->name === 'Admin')

<div class="card mb-4">

    <div class="card-header">
        Assign Technician
    </div>

    <div class="card-body">

        <form method="POST"
              action="{{ route('tickets.assign', $ticket) }}">

            @csrf
            @method('PUT')

            <select name="technician_id" class="form-select mb-3">

                <option value="">
                    Select Technician
                </option>

                @foreach($technicians as $tech)

                    <option
                        value="{{ $tech->id }}"
                        @selected($ticket->technician_id == $tech->id)>

                        {{ $tech->name }}

                    </option>

                @endforeach

            </select>

            <button class="btn btn-primary w-100">
                Assign Technician
            </button>

        </form>

    </div>

</div>

@endif

            {{-- UPDATE STATUS --}}

            @if(auth()->check() && auth()->user()->role &&
    in_array(auth()->user()->role->name, ['Admin', 'Technician']))

<!-- Update Status Card -->

<div class="card">

                <div class="card-header">
                    Update Status
                </div>

                <div class="card-body">

                    <form method="POST"
                          action="{{ route('tickets.status',$ticket) }}">

                        @csrf
                        @method('PUT')

                        <select
                            name="status"
                            class="form-select mb-3">

                            @foreach(['Assigned','In Progress','Resolved','Closed'] as $status)

                                <option
                                    value="{{ $status }}"
                                    @selected($ticket->status==$status)>

                                    {{ $status }}

                                </option>

                            @endforeach

                        </select>

                        <button class="btn btn-success w-100">

                            Update Status

                        </button>

                    </form>

                </div>

            </div>

@endif
            

        </div>

    </div>

</div>

<div class="card mt-4">

    <div class="card-header bg-dark text-white">
        <i class="bi bi-clock-history"></i>
        Activity Timeline
    </div>

    <div class="card-body">

        @forelse($ticket->activities as $activity)

            <div class="border-start border-4 border-primary ps-3 mb-3">

                <strong>{{ $activity->action }}</strong>

                <br>

                {{ $activity->description }}

                <br>

                <small class="text-muted">

                    {{ $activity->user->name }}

                    •

                    {{ $activity->created_at->diffForHumans() }}

                </small>

            </div>

        @empty

            <div class="alert alert-info">

                No activity recorded.

            </div>

        @endforelse

    </div>

</div>

@endsection