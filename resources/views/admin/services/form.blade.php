@extends('admin.layouts.app')

@section('content')

@php
    $isEdit = isset($service);
@endphp

<div class="card shadow mb-4">

    <!-- Card Header (same style as Assign Task) -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0">
            <strong>{{ $isEdit ? 'Edit Service' : 'Add Service' }}</strong>
        </h6>

        <a href="{{ route('admin.services.index') }}" class="btn btn-outline-secondary px-4">
            Back
        </a>
    </div>

    <!-- Card Body -->
    <div class="card-body">

        <form action="{{ $isEdit ? route('admin.services.update', $service->id) : route('admin.services.store') }}"
              method="POST">

            @csrf

            @if($isEdit)
                @method('PUT')
            @endif

            <div class="row">

                <!-- Name -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Service Name</label>
                    <input type="text"
                           name="name"
                           class="form-control"
                           placeholder="Enter service name"
                           value="{{ old('name', $service->name ?? '') }}"
                           required>
                </div>

                <!-- Description -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description"
                              class="form-control"
                              rows="1"
                              placeholder="Enter description">{{ old('description', $service->description ?? '') }}</textarea>
                </div>

                <!-- Status -->
                <div class="col-md-4 mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-control">
                        <option value="1" {{ (old('status', $service->status ?? '') == 1) ? 'selected' : '' }}>
                            Active
                        </option>
                        <option value="0" {{ (old('status', $service->status ?? '') == 0) ? 'selected' : '' }}>
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