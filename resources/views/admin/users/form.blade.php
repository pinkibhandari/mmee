@extends('admin.layouts.app')

@section('content')

@php
    $isEdit = isset($user);
@endphp

<div class="card shadow mb-4">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <strong>{{ $isEdit ? 'Edit User' : 'Add User' }}</strong>
        </h6>

        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary px-4">
            Back
        </a>
    </div>

    <!-- Body -->
    <div class="card-body">

        @can($isEdit ? 'can_edit_users' : 'can_create_users')
        <form action="{{ $isEdit ? route('admin.users.update', $user->id) : route('admin.users.store') }}"
              method="POST">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">

                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           value="{{ old('name', $user->name ?? '') }}"
                           required>
                </div>

                <!-- Email -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Email</label>
                    <input type="email"
                           name="email"
                           class="form-control"
                           value="{{ old('email', $user->email ?? '') }}"
                           required>
                </div>

                <!-- Password -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">
                        Password {{ $isEdit ? '(Optional)' : '' }}
                    </label>
                    <input type="password"
                           name="password"
                           class="form-control">
                </div>

                <!-- Role -->
                @can('can_edit_users') 
                <div class="col-md-4 mb-3">
                    <label class="form-label">Role</label>
                    <select name="role" class="form-control" required>
                        <option value="">Select Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ (old('role', $userRole ?? '') == $role->name) ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                </div>
                @endcan

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ (old('status', $user->status ?? 1) == 1) ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ (old('status', $user->status ?? 1) == 0) ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

            </div>

            <!-- Button -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>
                    {{ $isEdit ? 'Update' : 'Save' }}
                </button>
            </div>

        </form>
        @else
            <div class="alert alert-danger">
                You don't have permission to {{ $isEdit ? 'edit' : 'create' }} users.
            </div>
        @endcan

    </div>
</div>

@endsection