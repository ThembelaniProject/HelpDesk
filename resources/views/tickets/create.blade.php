@extends('layouts.app')

@section('content')

<div class="container-fluid">

    <div class="row justify-content-center">

        <div class="col-lg-10">

            <div class="card shadow">

                <div class="card-header bg-primary text-white">

                    <h3 class="mb-0">
                        <i class="bi bi-plus-circle"></i>
                        Create New Ticket
                    </h3>

                </div>

                <div class="card-body">

                    @if($errors->any())

                        <div class="alert alert-danger">

                            <ul class="mb-0">

                                @foreach($errors->all() as $error)

                                    <li>{{ $error }}</li>

                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form
                        action="{{ route('tickets.store') }}"
                        method="POST"
                        enctype="multipart/form-data">

                        @csrf

                        <div class="mb-3">

                            <label class="form-label">

                                Ticket Title

                            </label>

                            <input
                                type="text"
                                name="title"
                                class="form-control"
                                value="{{ old('title') }}"
                                required>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Category

                            </label>

                            <select
                                name="category_id"
                                class="form-select"
                                required>

                                <option value="">
                                    Select Category
                                </option>

                                @foreach($categories as $category)

                                    <option
                                        value="{{ $category->id }}"
                                        {{ old('category_id') == $category->id ? 'selected' : '' }}>

                                        {{ $category->name }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div class="mb-3">

                            <label class="form-label">

                                Priority

                            </label>

                            <select
                                name="priority"
                                class="form-select"
                                required>

                                <option value="">Select Priority</option>

                                <option value="Low" {{ old('priority')=='Low' ? 'selected' : '' }}>
                                    Low
                                </option>

                                <option value="Medium" {{ old('priority')=='Medium' ? 'selected' : '' }}>
                                    Medium
                                </option>

                                <option value="High" {{ old('priority')=='High' ? 'selected' : '' }}>
                                    High
                                </option>

                                <option value="Critical" {{ old('priority')=='Critical' ? 'selected' : '' }}>
                                    Critical
                                </option>

                            </select>

                        </div>

                        

                        <div class="mb-3">

                            <label class="form-label">

                                Description

                            </label>

                            <textarea
                                name="description"
                                rows="6"
                                class="form-control"
                                required>{{ old('description') }}</textarea>

                        </div>

                        <div class="mb-4">

                            <label class="form-label">

                                Attachment (Optional)

                            </label>

                            <input
                                type="file"
                                name="attachment"
                                class="form-control"
                                accept=".jpg,.jpeg,.png,.pdf,.doc,.docx,.xls,.xlsx">

                            <small class="text-muted">

                                Supported formats:
                                JPG, PNG, PDF, DOC, DOCX, XLS, XLSX
                                (Maximum 10MB)

                            </small>

                            @error('attachment')

                                <div class="text-danger mt-2">

                                    {{ $message }}

                                </div>

                            @enderror

                        </div>

                        <hr>

                        <button
                            type="submit"
                            class="btn btn-success">

                            <i class="bi bi-check-circle"></i>

                            Create Ticket

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