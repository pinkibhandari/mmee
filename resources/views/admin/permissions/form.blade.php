@extends('admin.layouts.app')

@section('content')

@php
    $isEdit = isset($permission);
@endphp

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">
        <h6><strong>{{ $isEdit ? 'Edit Permission' : 'Add Permission' }}</strong></h6>

        <a href="{{ route('admin.permissions.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card-body">

        @can($isEdit ? 'can_edit_permission' : 'can_create_permission')

        <form action="{{ $isEdit ? route('admin.permissions.update',$permission->id) : route('admin.permissions.store') }}"
              method="POST">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="mb-3">
                <label>Permission Name</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $permission->name ?? '') }}"
                       class="form-control"
                       placeholder="ex: can_create_users"
                       required>
            </div>

            <button class="btn btn-primary">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>

        </form>

        @else
            <div class="alert alert-danger">
                You don't have permission to {{ $isEdit ? 'edit' : 'create' }} permissions.
            </div>
        @endcan

    </div>
</div>

@endsection