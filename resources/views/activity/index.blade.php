@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <h2>
            <i class="bi bi-clock-history"></i>
            Activity Logs
        </h2>

        <a href="{{ route('dashboard') }}" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i>
            Back
        </a>

    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <i class="bi bi-list-ul"></i>

            System Activity

        </div>

        <div class="card-body p-0">

            <div class="table-responsive">

                <table class="table table-hover table-striped mb-0">

                    <thead class="table-primary">

                        <tr>

                            <th width="80">ID</th>

                            <th>User</th>

                            <th>Role</th>

                            <th>Action</th>

                            <th>Description</th>

                            <th>Date</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($activities as $activity)

                            <tr>

                                <td>
                                    {{ $activity->id }}
                                </td>

                                <td>

                                    <strong>

                                        {{ $activity->user->name ?? 'Deleted User' }}

                                    </strong>

                                </td>

                                <td>

                                    @if(isset($activity->user->role))

                                        @if($activity->user->role->name == 'Admin')

                                            <span class="badge bg-danger">
                                                Admin
                                            </span>

                                        @elseif($activity->user->role->name == 'Technician')

                                            <span class="badge bg-warning text-dark">
                                                Technician
                                            </span>

                                        @else

                                            <span class="badge bg-primary">
                                                User
                                            </span>

                                        @endif

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    <span class="badge bg-success">

                                        {{ $activity->action }}

                                    </span>

                                </td>

                                <td>

                                    {{ $activity->description }}

                                </td>

                                <td>

                                    {{ $activity->created_at->format('d M Y H:i') }}

                                    <br>

                                    <small class="text-muted">

                                        {{ $activity->created_at->diffForHumans() }}

                                    </small>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="6" class="text-center py-5">

                                    <i class="bi bi-clock-history display-4 text-secondary"></i>

                                    <br><br>

                                    No activity has been recorded yet.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        <div class="card-footer">

            {{ $activities->links() }}

        </div>

    </div>

</div>

@endsection