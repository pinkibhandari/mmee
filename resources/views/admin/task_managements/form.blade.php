@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0">
                <strong>{{ $task ? 'Edit Task' : 'Add Task' }}</strong>
            </h6>

            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-secondary">
                Back
            </a>
        </div>

        <div class="card-body">

            <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">

                @csrf

                @if ($task)
                    @method('PUT')
                @endif

                <div class="row">

                    <!-- Task Code -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Task Code</label>

                        <input type="text" class="form-control" value="{{ $task->task_code ?? $previewCode }}" readonly>
                    </div>

                    <!-- Task Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Task Type</label>

                        <select name="task_type" id="task_type" class="form-select">

                            <option value="">Select Type</option>

                            <option value="site"
                                {{ old('task_type', $task->task_type ?? '') == 'site' ? 'selected' : '' }}>
                                Site Task
                            </option>

                            <option value="manual"
                                {{ old('task_type', $task->task_type ?? '') == 'manual' ? 'selected' : '' }}>
                                Manual Task
                            </option>

                        </select>
                    </div>

                    <!-- Site Select -->
                    <div class="col-md-4 mb-3 {{ old('task_type', $task->task_type ?? '') == 'site' ? '' : 'd-none' }}"
                        id="site_div">

                        <label class="form-label">Select Site</label>

                        <select name="site_id" id="site_select" class="form-select">

                            <option value="">Select Site</option>

                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" data-name="{{ $site->site_name }}"
                                    data-address="{{ $site->address }}" data-latitude="{{ $site->latitude }}"
                                    data-longitude="{{ $site->longitude }}"
                                    {{ old('site_id', $task->site_id ?? '') == $site->id ? 'selected' : '' }}>

                                    {{ $site->site_name }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Task Name -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Task Name</label>

                        <input type="text" name="task_name" id="task_name" class="form-control"
                            value="{{ old('task_name', $task->task_name ?? '') }}">
                    </div>

                    <!-- Address -->
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Address</label>

                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ old('address', $task->address ?? '') }}">
                    </div>

                    <!-- Latitude -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Latitude</label>

                        <input type="text" name="latitude" id="latitude" class="form-control"
                            value="{{ old('latitude', $task->latitude ?? '') }}">
                    </div>

                    <!-- Longitude -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Longitude</label>

                        <input type="text" name="longitude" id="longitude" class="form-control"
                            value="{{ old('longitude', $task->longitude ?? '') }}">
                    </div>

                    <!-- Priority -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Priority</label>

                        <select name="priority" class="form-select">

                            <option value="low" {{ old('priority', $task->priority ?? '') == 'low' ? 'selected' : '' }}>
                                Low
                            </option>

                            <option value="medium"
                                {{ old('priority', $task->priority ?? '') == 'medium' ? 'selected' : '' }}>
                                Medium
                            </option>

                            <option value="high"
                                {{ old('priority', $task->priority ?? '') == 'high' ? 'selected' : '' }}>
                                High
                            </option>

                            <option value="urgent"
                                {{ old('priority', $task->priority ?? '') == 'urgent' ? 'selected' : '' }}>
                                Urgent
                            </option>

                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>

                        <select name="status" class="form-select">

                            <option value="assigned"
                                {{ old('status', $task->status ?? '') == 'assigned' ? 'selected' : '' }}>
                                Assigned
                            </option>

                            <option value="in_progress"
                                {{ old('status', $task->status ?? '') == 'in_progress' ? 'selected' : '' }}>
                                In Progress
                            </option>

                            <option value="completed"
                                {{ old('status', $task->status ?? '') == 'completed' ? 'selected' : '' }}>
                                Completed
                            </option>

                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Due Date</label>

                        <input type="date" name="due_date" class="form-control" min="{{ date('Y-m-d') }}"
                            value="{{ old('due_date', isset($task->due_date) ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
                    </div>

                    <!-- Title -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>

                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $task->title ?? '') }}">
                    </div>

                    <!-- Assign To -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Assign To</label>

                        <select name="assigned_to" class="form-select">

                            <option value="">Select User</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to', $task->assigned_to ?? '') == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }}

                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Work Note -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Work Note</label>

                        <textarea name="work_notes" class="form-control" rows="2">{{ old('work_notes', $task->work_notes ?? '') }}</textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>

                        <textarea name="description" class="form-control" rows="3">{{ old('description', $task->description ?? '') }}</textarea>
                    </div>

                </div>

                <button type="submit" class="btn btn-success px-4">
                    {{ $task ? 'Update Task' : 'Save Task' }}
                </button>

            </form>

        </div>
    </div>

    <script>
        const taskType = document.getElementById('task_type');
        const siteDiv = document.getElementById('site_div');
        const siteSelect = document.getElementById('site_select');

        // Show/Hide site dropdown
        taskType.addEventListener('change', function() {

            siteDiv.classList.add('d-none');

            if (this.value === 'site') {
                siteDiv.classList.remove('d-none');
            }
        });

        // Fill site data
        function fillSiteData() {

            let selected = siteSelect.options[siteSelect.selectedIndex];

            if (!selected.value) return;

            document.getElementById('task_name').value =
                selected.getAttribute('data-name');

            document.getElementById('address').value =
                selected.getAttribute('data-address');

            document.getElementById('latitude').value =
                selected.getAttribute('data-latitude');

            document.getElementById('longitude').value =
                selected.getAttribute('data-longitude');
        }

        // On site change
        siteSelect.addEventListener('change', fillSiteData);

        // Edit mode auto fill
        window.addEventListener('load', function() {

            if (taskType.value === 'site') {

                siteDiv.classList.remove('d-none');

                if (siteSelect.value) {
                    fillSiteData();
                }
            }
        });
    </script>
@endsection
