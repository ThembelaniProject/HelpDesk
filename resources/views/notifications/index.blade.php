@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card">

        <div class="card-header">
            All Notifications
        </div>

        <div class="card-body">

            @forelse($notifications as $notification)

                <div class="border-bottom pb-3 mb-3">

                    <h5>{{ $notification->title }}</h5>

                    <p>{{ $notification->message }}</p>

                    <small class="text-muted">
                        {{ $notification->created_at->diffForHumans() }}
                    </small>

                </div>

            @empty

                <div class="alert alert-info">
                    No notifications found.
                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection