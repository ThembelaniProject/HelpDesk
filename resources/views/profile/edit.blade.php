@extends('layouts.app')

@section('content')

<div class="container">

<div class="row">

<div class="col-lg-4">

<div class="card shadow">

<div class="card-body text-center">

@if($user->profile_photo)

<img
src="{{ asset('storage/'.$user->profile_photo) }}"
class="rounded-circle mb-3"
width="150"
height="150"
style="object-fit:cover;">

@else

<i class="bi bi-person-circle display-1 text-primary"></i>

@endif

<h4>

{{ $user->name }}

</h4>

<p>

{{ $user->email }}

</p>

<hr>

<div class="row text-center">

<div class="col-6">

<h4>{{ $stats['total'] }}</h4>

<small>Total Tickets</small>

</div>

<div class="col-6">

<h4>{{ $stats['resolved'] }}</h4>

<small>Resolved</small>

</div>

</div>

<hr>

<div class="row text-center">

<div class="col-6">

<h4>{{ $stats['open'] }}</h4>

<small>Open</small>

</div>

<div class="col-6">

<h4>{{ $stats['closed'] }}</h4>

<small>Closed</small>

</div>

</div>

</div>

</div>

</div>

<div class="col-lg-8">

<div class="card shadow">

<div class="card-header">

Edit Profile

</div>

<div class="card-body">

<form method="POST"
      action="{{ route('profile.update') }}"
      enctype="multipart/form-data">

    @csrf
    @method('PATCH')

    <div class="mb-3">
        <label>Name</label>
        <input
            type="text"
            name="name"
            class="form-control"
            value="{{ old('name',$user->name) }}">
    </div>

    <div class="mb-3">
        <label>Email</label>
        <input
            type="email"
            name="email"
            class="form-control"
            value="{{ old('email',$user->email) }}">
    </div>

    <div class="mb-3">
        <label>Profile Photo</label>
        <input
            type="file"
            name="profile_photo"
            class="form-control">
    </div>

    <button class="btn btn-primary">
        Save Profile
    </button>

</form>

<hr>

<h5>Change Password</h5>

<form method="POST"
      action="{{ route('profile.password') }}">

    @csrf
    @method('PUT')

    <div class="mb-3">
        <label>Current Password</label>

        <input
            type="password"
            name="current_password"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label>New Password</label>

        <input
            type="password"
            name="password"
            class="form-control"
            required>
    </div>

    <div class="mb-3">
        <label>Confirm Password</label>

        <input
            type="password"
            name="password_confirmation"
            class="form-control"
            required>
    </div>

    <button class="btn btn-success">
        Change Password
    </button>

</form>
</div>

</div>

</div>

</div>

</div>

@endsection