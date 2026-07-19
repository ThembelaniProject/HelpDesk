@extends('layouts.app')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h3>Edit User</h3>

        </div>

        <div class="card-body">

            <form action="{{ route('users.update', $user) }}" method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label>Name</label>

                    <input
                        type="text"
                        name="name"
                        class="form-control"
                        value="{{ old('name', $user->name) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Email</label>

                    <input
                        type="email"
                        name="email"
                        class="form-control"
                        value="{{ old('email', $user->email) }}"
                        required>

                </div>

                <div class="mb-3">

                    <label>Role</label>

                    <select name="role_id" class="form-select">

                        @foreach($roles as $role)

                            <option
                                value="{{ $role->id }}"
                                @selected($user->role_id == $role->id)>

                                {{ $role->name }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <button class="btn btn-success">

                    Update User

                </button>

            </form>

        </div>

    </div>

</div>

@endsection