@extends('admin.layouts.app')

@section('content')
    <div class="container-fluid">

        <div class="card shadow-lg border-0 rounded-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header d-flex justify-content-between align-items-center bg-white py-3 px-4 border-bottom">

                <div>
                    <h6 class="mb-0"><strong><i class="fas fa-tasks me-2 text-primary"></i> Task Details</strong></h6>
                    <small class="text-muted">
                        Complete information about this task
                    </small>
                </div>

                <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-secondary">

                    <i class="fas fa-arrow-left me-1"></i>
                    Back

                </a>

            </div>

            <!-- Body -->
            <div class="card-body p-4">

                <!-- Top Info -->
                <div class="row g-4 mb-4">

                    <!-- Task Code -->
                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                            <!-- Top Border -->
                            <div class="bg-primary" style="height: 5px;"></div>

                            <div class="card-body p-3">

                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <div>

                                        <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                            style="font-size: 11px; letter-spacing: .8px;">

                                            Task Code

                                        </small>

                                        <h5 class="fw-bold text-dark mb-0">
                                            {{ $task->task_code ?? 'N/A' }}
                                        </h5>

                                    </div>



                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Task Type -->
                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                            <!-- Top Border -->
                            <div class="bg-success" style="height: 5px;"></div>

                            <div class="card-body p-3">

                                <div class="d-flex align-items-center justify-content-between mb-2">

                                    <div>

                                        <small class="text-uppercase text-muted fw-bold d-block mb-1"
                                            style="font-size: 11px; letter-spacing: .8px;">

                                            Task Type

                                        </small>

                                        <h5 class="fw-bold text-dark text-capitalize mb-0">
                                            {{ $task->task_type ?? 'N/A' }}
                                        </h5>

                                    </div>


                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Priority -->
                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                            <!-- Top Border -->
                            <div class="bg-danger" style="height: 5px;"></div>

                            <div class="card-body p-3">

                                <div class="d-flex align-items-center justify-content-between">

                                    <div>

                                        <small class="text-uppercase text-muted fw-bold d-block mb-2"
                                            style="font-size: 11px; letter-spacing: .8px;">

                                            Priority

                                        </small>

                                        @if ($task->priority == 'low')
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-arrow-down me-1"></i> Low
                                            </span>
                                        @elseif($task->priority == 'medium')
                                            <span class="badge bg-info text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-equals me-1"></i> Medium
                                            </span>
                                        @elseif($task->priority == 'high')
                                            <span class="badge bg-warning text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-arrow-up me-1"></i> High
                                            </span>
                                        @elseif($task->priority == 'urgent')
                                            <span class="badge bg-danger text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-bolt me-1"></i> Urgent
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                                N/A
                                            </span>
                                        @endif

                                    </div>



                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Status -->
                    <div class="col-md-3">

                        <div class="card border-0 shadow-sm rounded-4 h-100 overflow-hidden">

                            <!-- Top Border -->
                            <div class="bg-warning" style="height: 5px;"></div>

                            <div class="card-body p-3">

                                <div class="d-flex align-items-center justify-content-between">

                                    <div>

                                        <small class="text-uppercase text-muted fw-bold d-block mb-2"
                                            style="font-size: 11px; letter-spacing: .8px;">

                                            Status

                                        </small>

                                        @if ($task->status == 'assigned')
                                            <span class="badge bg-primary text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-user-check me-1"></i> Assigned
                                            </span>
                                        @elseif($task->status == 'in_progress')
                                            <span class="badge bg-warning text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-spinner me-1"></i> In Progress
                                            </span>
                                        @elseif($task->status == 'completed')
                                            <span class="badge bg-success text-white px-3 py-2 rounded-pill">
                                                <i class="fas fa-check-circle me-1"></i> Completed
                                            </span>
                                        @else
                                            <span class="badge bg-secondary px-3 py-2 rounded-pill">
                                                N/A
                                            </span>
                                        @endif

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

                <!-- Main Info -->
                <div class="row g-4">

                    <!-- Left -->
                    <div class="col-lg-8">

                        <div class="card border-0 shadow-sm rounded-4 mb-4">

                            <div class="card-header bg-white border-0 pt-4 px-4">

                                <h6 class="fw-bold mb-0">
                                    <i class="fas fa-info-circle me-2 text-primary"></i>
                                    Basic Information
                                </h6>

                            </div>

                            <div class="card-body px-4 pb-4">

                                <div class="row align-items-start mb-4">

                                    <!-- Task Name -->
                                    <div class="col-md-6 mb-3 mb-md-0">

                                        <small class="text-muted fw-bold d-block mb-1">
                                            Task Name :
                                        </small>
                                        <p class="fw-semibold text-secondary fs-6 mb-0">
                                            {{ $task->task_name ?? 'N/A' }}
                                        </p>


                                    </div>

                                    <!-- Title -->
                                    <div class="col-md-6">

                                        <small class="text-muted fw-bold  d-block mb-1">
                                            Title :
                                        </small>

                                        <p class="fw-semibold text-secondary fs-6 mb-0">
                                            {{ $task->title ?? 'N/A' }}
                                        </p>

                                    </div>

                                </div>

                                <hr class="my-4 opacity-25">

                                <div class="mb-4">

                                    <label class="text-muted small mb-1">
                                        Description :
                                    </label>

                                    <div class="border rounded-4 p-3 bg-light">
                                        {{ $task->description ?? 'N/A' }}
                                    </div>

                                </div>

                                <div>

                                    <label class="text-muted small mb-1">
                                        Work Notes :
                                    </label>

                                    <div class="border rounded-4 p-3 bg-light">
                                        {{ $task->work_notes ?? 'N/A' }}
                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                    <!-- Right -->
                    <div class="col-lg-4">

                        <div class="card border-0 shadow-sm rounded-4 mb-4">

                            <div class="card-header bg-white border-0 pt-4 px-4">

                                <h6 class="fw-bold mb-0">
                                    <i class="fas fa-user-check me-2 text-success"></i>
                                    Assignment
                                </h6>

                            </div>

                            <div class="card-body px-4 pb-4">

                                <div class="mb-4">

                                    <label class="text-muted small mb-1">
                                        Assigned To :
                                    </label>

                                    <div class="fw-semibold">
                                        {{ $task->employee->name ?? 'N/A' }}
                                    </div>

                                </div>
                                <div class="row align-items-start">

                                    <!-- Due Date -->
                                    <div class="col-md-6 mb-3 mb-md-0">

                                        <small class="text-muted fw-bold  d-block mb-1">
                                            Due Date :
                                        </small>

                                        <div class="fw-semibold text-dark fs-6">
                                            {{ $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('d M Y') : 'N/A' }}
                                        </div>

                                    </div>

                                    <!-- Created By -->
                                    <div class="col-md-6">

                                        <small class="text-muted fw-bold  d-block mb-1">
                                            Created By :
                                        </small>

                                        <div class="fw-semibold text-dark fs-6">
                                            {{ $task->creator->name ?? 'N/A' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                        <!-- Location -->
                        <div class="card border-0 shadow-sm rounded-4">

                            <div class="card-header bg-white border-0 pt-4 px-4">

                                <h6 class="fw-bold mb-0">
                                    <i class="fas fa-map-marker-alt me-2 text-danger"></i>
                                    Location Details
                                </h6>

                            </div>

                            <div class="card-body px-4 pb-4">

                                <div class="mb-4">

                                    <label class="text-muted small mb-1">
                                        Address :
                                    </label>

                                    <div class="fw-semibold">
                                        {{ $task->address ?? 'N/A' }}
                                    </div>

                                </div>

                                <div class="row">

                                    <div class="col-6">

                                        <label class="text-muted small mb-1">
                                            Latitude :
                                        </label>

                                        <div class="fw-semibold">
                                            {{ $task->latitude ?? 'N/A' }}
                                        </div>

                                    </div>

                                    <div class="col-6">

                                        <label class="text-muted small mb-1">
                                            Longitude :
                                        </label>

                                        <div class="fw-semibold">
                                            {{ $task->longitude ?? 'N/A' }}
                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>
@endsection
