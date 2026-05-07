@extends('admin.layouts.app')

@section('content')

@php
    $isEdit = isset($site);
@endphp

<div class="card shadow mb-4">

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <strong>{{ $isEdit ? 'Edit Site' : 'Add Site' }}</strong>
        </h6>

        <a href="{{ route('admin.sites.index') }}" class="btn btn-outline-secondary px-4">
            Back
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <form action="{{ $isEdit ? route('admin.sites.update', $site->id) : route('admin.sites.store') }}"
              method="POST">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">

                <!-- Site Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Site Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter site name"
                           value="{{ old('name', $site->site_name ?? '') }}"
                           required>
                </div>

                <!-- Address -->
                <div class="col-md-8 mb-3">
                    <label class="form-label">Address</label>
                    <input type="text"
                           name="address"
                           class="form-control"
                           placeholder="Enter address"
                           value="{{ old('address', $site->address ?? '') }}">
                </div>

                <!-- Latitude -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Latitude</label>
                    <input type="text"
                           name="latitude"
                           class="form-control"
                           placeholder="Enter latitude"
                           value="{{ old('latitude', $site->latitude ?? '') }}">
                </div>

                <!-- Longitude -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Longitude</label>
                    <input type="text"
                           name="longitude"
                           class="form-control"
                           placeholder="Enter longitude"
                           value="{{ old('longitude', $site->longitude ?? '') }}">
                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ (old('status', $site->status ?? '') == 1) ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ (old('status', $site->status ?? '') == 0) ? 'selected' : '' }}>
                            Inactive
                        </option>
                    </select>
                </div>

            </div>

            <!-- Buttons -->
            <div class="mt-3">
                <button type="submit" class="btn btn-primary px-4">
                    <i class="fas fa-save me-1"></i>
                    {{ $isEdit ? 'Update' : 'Save' }}
                </button>
            </div>

        </form>

    </div>
</div>

@endsection