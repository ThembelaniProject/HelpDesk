@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow">

                <div class="card-header bg-warning">

                    <h3>
                        <i class="bi bi-pencil-square"></i>
                        Edit Ticket #{{ $ticket->id }}
                    </h3>

                </div>

                <div class="card-body">

                    @if ($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form action="{{ route('tickets.update',$ticket) }}" method="POST" enctype="multipart/form-data">

                        @csrf
                        @method('PUT')

                        <div class="mb-3">

                            <label class="form-label">Title</label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title',$ticket->title) }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">Category</label>

                            <select name="category_id" class="form-select">

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        @selected($ticket->category_id==$category->id)>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="row">

                            <div class="col-md-4">

                                <label class="form-label">

                                    Priority

                                </label>

                                <select
                                    name="priority"
                                    class="form-select">

                                    <option value="Low" @selected($ticket->priority=='Low')>Low</option>

                                    <option value="Medium" @selected($ticket->priority=='Medium')>Medium</option>

                                    <option value="High" @selected($ticket->priority=='High')>High</option>

                                    <option value="Critical" @selected($ticket->priority=='Critical')>Critical</option>

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">

                                    Status

                                </label>

                                <select
                                    name="status"
                                    class="form-select">

                                    <option value="Open" @selected($ticket->status=='Open')>Open</option>

                                    <option value="Assigned" @selected($ticket->status=='Assigned')>Assigned</option>

                                    <option value="In Progress" @selected($ticket->status=='In Progress')>In Progress</option>

                                    <option value="Resolved" @selected($ticket->status=='Resolved')>Resolved</option>

                                    <option value="Closed" @selected($ticket->status=='Closed')>Closed</option>

                                </select>

                            </div>

                            <div class="col-md-4">

                                <label class="form-label">

                                    Technician

                                </label>

                                <select
                                    name="technician_id"
                                    class="form-select">

                                    <option value="">

                                        Not Assigned

                                    </option>

                                    @foreach($technicians as $technician)

                                        <option
                                            value="{{ $technician->id }}"
                                            @selected($ticket->technician_id==$technician->id)>

                                            {{ $technician->name }}

                                        </option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                        <div class="mt-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                name="description"
                                rows="7"
                                class="form-control"
                                required>{{ old('description',$ticket->description) }}</textarea>

                        </div>

                        <div class="mt-3">

                            <label class="form-label">

                                Replace Attachment

                            </label>

                            <input
                                type="file"
                                name="attachment"
                                class="form-control">

                        </div>

                        <hr>

                        <button
                            class="btn btn-success">

                            <i class="bi bi-save"></i>

                            Update Ticket

                        </button>

                        <a
                            href="{{ route('tickets.index') }}"
                            class="btn btn-secondary">

                            Cancel

                        </a>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection