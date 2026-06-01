@extends('admin.layouts.app')

@section('content')

@php
    $isEdit = isset($role);
@endphp

<div class="card shadow">

    <div class="card-header d-flex justify-content-between">
        <h6><strong>{{ $isEdit ? 'Edit Role' : 'Add Role' }}</strong></h6>

        <a href="{{ route('admin.roles.index') }}" class="btn btn-secondary">Back</a>
    </div>

    <div class="card-body">

        @can($isEdit ? 'can_edit_roles' : 'can_create_roles')

        <form action="{{ $isEdit ? route('admin.roles.update',$role->id) : route('admin.roles.store') }}"
              method="POST">
            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <!-- Role Name -->
            <div class="mb-3">
                <label>Role Name</label>
                 <input type="text" name="name" value="{{ old('name', isset($role) ? ucwords(str_replace('_', ' ', $role->name)) : '') }}"
                      class="form-control" required>
                <!-- <input type="text" name="name"
                       value="{{ old('name', $role->name ?? '') }}"
                       class="form-control" required> -->
            </div>

            <!-- Permissions -->
            <div class="mb-3">
                <label>Permissions</label>
                <div class="row">

                    @foreach($permissions as $permission)
                        <div class="col-md-3">
                            <label>
                                <input type="checkbox"
                                       name="permissions[]"
                                       value="{{ $permission->name }}"
                                       {{ (isset($rolePermissions) && in_array($permission->name, $rolePermissions)) ? 'checked' : '' }}>
                                {{ $permission->name }}
                            </label>
                        </div>
                    @endforeach

                </div>
            </div>

            <button class="btn btn-primary">
                {{ $isEdit ? 'Update' : 'Save' }}
            </button>

        </form>

        @else
            <div class="alert alert-danger">
                You don't have permission to {{ $isEdit ? 'edit' : 'create' }} roles.
            </div>
        @endcan

    </div>
</div>

@endsection