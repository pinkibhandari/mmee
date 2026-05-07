@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>{{ $task ? 'Edit Task' : 'Add Task' }}</strong></h6>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-secondary">Back</a>
        </div>

        <div class="card-body">

            <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">
                @csrf
                @if ($task)
                    @method('PUT')
                @endif

                <div class="row">

                    <!-- Task Code (Auto) -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Task Code</label>
                        <input type="text" class="form-control" value="{{ $task->task_code ?? $previewCode }}" readonly>
                    </div>

                    <!-- Task Type -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Task Type</label>
                        <select name="task_type" id="task_type" class="form-select">
                            <option value="">Select Type</option>
                            <option value="site">Site Task</option>
                            <option value="manual">Manual Task</option>
                        </select>
                    </div>

                    <!-- Site Select -->
                    <div class="col-md-4 mb-3 d-none" id="site_div">
                        <label class="form-label">Select Site</label>
                        <select name="site_id" id="site_select" class="form-select">
                            <option value="">Select Site</option>

                            @foreach ($sites as $site)
                                <option value="{{ $site->id }}" data-name="{{ $site->site_name }}"
                                    data-address="{{ $site->address }}" data-lat="{{ $site->lat }}"
                                    data-lng="{{ $site->lng }}">

                                    {{ $site->site_name }}
                                </option>
                            @endforeach

                        </select>
                    </div>

                    <!-- Task Name -->
                    <div class="col-md-6 mb-3" id="task_name_div">
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

                    <!-- Lat -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Latitude</label>
                        <input type="text" name="lat" id="lat" class="form-control">
                    </div>

                    <!-- Lng -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Longitude</label>
                        <input type="text" name="lng" id="lng" class="form-control">
                    </div>

                    <!-- Priority -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Priority</label>
                        <select name="priority" class="form-select">
                            <option value="low">Low</option>
                            <option value="medium">Medium</option>
                            <option value="high">High</option>
                            <option value="urgent">Urgent</option>

                        </select>
                    </div>

                    <!-- Status -->
                    <div class="col-md-3 mb-3">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-select">
                            <option value="0">Pending</option>
                            <option value="1">Completed</option>
                            <option value="2">In Progress</option>
                            <option value="3">Accepted</option>
                        </select>
                    </div>

                    <!-- Due Date -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Due Date</label>
                        <input type="date" name="due_date" class="form-control">
                    </div>

                    <!-- Title -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control">
                    </div>

                    <!-- Assign To -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Assign To</label>
                        <input type="text" name="assigned_to" class="form-control">
                    </div>
                    <!-- Created By -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Created By</label>
                        <input type="text" name="created_by" class="form-control">
                    </div>

                    <!-- Work Note -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Work Note</label>
                        <textarea name="work_note" class="form-control" rows="2"></textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" class="form-control" rows="3"></textarea>
                    </div>

                </div>

                <button class="btn btn-success px-4">Save Task</button>

            </form>

        </div>
    </div>

    <!-- JS -->
    <script>
        document.getElementById('task_type').addEventListener('change', function() {
            let type = this.value;

            document.getElementById('site_div').classList.add('d-none');

            if (type === 'site') {
                document.getElementById('site_div').classList.remove('d-none');
            }
        });

        // Auto fill site data
        document.getElementById('site_select').addEventListener('change', function() {
            let selected = this.options[this.selectedIndex];

            document.getElementById('task_name').value = selected.getAttribute('data-name');
            document.getElementById('address').value = selected.getAttribute('data-address');
            document.getElementById('lat').value = selected.getAttribute('data-lat');
            document.getElementById('lng').value = selected.getAttribute('data-lng');
        });
    </script>
@endsection
