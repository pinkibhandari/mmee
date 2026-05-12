@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4 border-0">
        <style>
            .custom-dropdown {
                width: 100%;
            }

            #selectedUserBtn {
                height: 48px;
                border-radius: 10px;
                background: #fff;
                border: 1px solid #dcdcdc;
                font-weight: 500;
                cursor: pointer;
            }

            #selectedUserBtn:focus {
                box-shadow: none;
                border-color: #0d6efd;
            }

            .dropdown-box {
                position: absolute;
                width: 100%;
                background: #fff;
                border: 1px solid #e5e5e5;
                border-radius: 12px;
                margin-top: 8px;
                z-index: 999;
                overflow: hidden;
            }

            .user-list {
                max-height: 250px;
                overflow-y: auto;
            }

            .user-item {
                cursor: pointer;
                transition: 0.2s;
                border-bottom: 1px solid #f1f1f1;
            }

            .user-item:hover {
                background: #f5f7ff;
                color: #0d6efd;
            }

            #searchUser {
                border-radius: 8px;
                height: 42px;
            }

            #searchUser:focus {
                box-shadow: none;
                border-color: #0d6efd;
            }
        </style>

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center py-3">
            <h6 class="mb-0">
                <strong>{{ $task ? 'Edit Task' : 'Add Task' }}</strong>
            </h6>

            <a href="{{ route('admin.tasks.index') }}" class="btn btn-sm btn-secondary px-3">
                Back
            </a>
        </div>

        <div class="card-body">

            <form action="{{ $task ? route('admin.tasks.update', $task->id) : route('admin.tasks.store') }}" method="POST">

                @csrf

                @if ($task)
                    @method('PUT')
                @endif

                <div class="row g-3">

                    <!-- Task Code -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Task Code</label>

                        <input type="text" class="form-control" value="{{ $task->task_code ?? $previewCode }}" readonly>
                    </div>

                    <!-- Task Type -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Task Type</label>

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
                    <div class="col-lg-4 col-md-6 col-12 {{ old('task_type', $task->task_type ?? '') == 'site' ? '' : 'd-none' }}"
                        id="site_div">

                        <label class="form-label fw-semibold">Select Site</label>

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
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Task Name</label>

                        <input type="text" name="task_name" id="task_name" class="form-control"
                            value="{{ old('task_name', $task->task_name ?? '') }}">
                    </div>

                    <!-- Address -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Address</label>

                        <input type="text" name="address" id="address" class="form-control"
                            value="{{ old('address', $task->address ?? '') }}">
                    </div>

                    <!-- Latitude -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Latitude</label>

                        <input type="text" name="latitude" id="latitude" class="form-control"
                            value="{{ old('latitude', $task->latitude ?? '') }}">
                    </div>

                    <!-- Longitude -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Longitude</label>

                        <input type="text" name="longitude" id="longitude" class="form-control"
                            value="{{ old('longitude', $task->longitude ?? '') }}">
                    </div>

                    <!-- Priority -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Priority</label>

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
                    {{-- <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Status</label>

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
                    </div> --}}
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">
                            Start Date
                        </label>

                        <input type="date" name="start_date" class="form-control" min="{{ date('Y-m-d') }}"
                            value="{{ old('start_date', isset($task->start_date) ? \Carbon\Carbon::parse($task->start_date)->format('Y-m-d') : '') }}">
                    </div>
                    <!-- End Date -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">End Date</label>

                        <input type="date" name="end_date" class="form-control" min="{{ date('Y-m-d') }}"
                            value="{{ old('end_date', isset($task->end_date) ? \Carbon\Carbon::parse($task->end_date)->format('Y-m-d') : '') }}">
                    </div>

                    <!-- Title -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Title</label>

                        <input type="text" name="title" class="form-control"
                            value="{{ old('title', $task->title ?? '') }}">
                    </div>

                    <!-- Customer Name -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Customer Name</label>

                        <input type="text" name="customer_name" class="form-control"
                            value="{{ old('customer_name', $task->customer_name ?? '') }}">
                    </div>

                    <!-- Customer Phone -->
                    <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Customer Phone</label>

                        <input type="text" name="customer_phone" class="form-control" maxlength="10"
                            value="{{ old('customer_phone', $task->customer_phone ?? '') }}">
                    </div>

                    <!-- Assign To -->
                    {{-- <div class="col-lg-4 col-md-6 col-12">
                        <label class="form-label fw-semibold">Assign To</label>

                        <select name="assigned_to" class="form-select">

                            <option value="">Select User</option>

                            @foreach ($users as $user)
                                <option value="{{ $user->id }}"
                                    {{ old('assigned_to', $task->assigned_to ?? '') == $user->id ? 'selected' : '' }}>

                                    {{ $user->name }}

                                </option>
                            @endforeach

                        </select>
                    </div> --}}
                    <!-- Assign To -->
                    <div class="col-lg-4 col-md-6 col-12">

                        <label class="form-label fw-semibold mb-2">
                            Assign To
                        </label>

                        <div class="custom-dropdown position-relative">

                            <!-- Selected Button -->
                            <button type="button"
                                class="form-control text-start d-flex justify-content-between align-items-center"
                                id="selectedUserBtn">

                                <span id="selectedUserText">
                                    @php
                                        $selectedUser = $users
                                            ->where('id', old('assigned_to', $task->assigned_to ?? ''))
                                            ->first();
                                    @endphp

                                    {{ $selectedUser->name ?? 'Select Employee' }}
                                </span>

                                <i class="fas fa-chevron-down"></i>
                            </button>

                            <!-- Dropdown Box -->
                            <div class="dropdown-box shadow-sm d-none" id="dropdownBox">

                                <!-- Search -->
                                <div class="p-2 border-bottom bg-white sticky-top">
                                    <input type="text" class="form-control" id="searchUser"
                                        placeholder="Search Employee...">
                                </div>

                                <!-- User List -->
                                <div class="user-list">

                                    @foreach ($users as $user)
                                        <div class="user-item px-3 py-2" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}">

                                            {{ $user->name }}

                                        </div>
                                    @endforeach

                                </div>

                            </div>

                            <!-- Hidden Input -->
                            <input type="hidden" name="assigned_to" id="assigned_to"
                                value="{{ old('assigned_to', $task->assigned_to ?? '') }}">

                        </div>
                    </div>



                    <!-- Work Note -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Work Note</label>

                        <textarea name="work_notes" class="form-control" rows="2">{{ old('work_notes', $task->work_notes ?? '') }}</textarea>
                    </div>

                    <!-- Description -->
                    <div class="col-12">
                        <label class="form-label fw-semibold">Description</label>

                        <textarea name="description" class="form-control" rows="3">{{ old('description', $task->description ?? '') }}</textarea>
                    </div>

                </div>

                <!-- Submit -->
                <div class="mt-4">
                    <button type="submit" class="btn btn-success px-4">
                        {{ $task ? 'Update Task' : 'Save Task' }}
                    </button>
                </div>

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

        // Allow only 10 digit phone
        document.querySelector('input[name="customer_phone"]').addEventListener('input', function(e) {
            this.value = this.value.replace(/\D/g, '').slice(0, 10);
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {

            const dropdownBtn = document.getElementById("selectedUserBtn");
            const dropdownBox = document.getElementById("dropdownBox");
            const searchInput = document.getElementById("searchUser");
            const userItems = document.querySelectorAll(".user-item");
            const selectedText = document.getElementById("selectedUserText");
            const hiddenInput = document.getElementById("assigned_to");

            // Toggle Dropdown
            dropdownBtn.addEventListener("click", function() {

                dropdownBox.classList.toggle("d-none");

                if (!dropdownBox.classList.contains("d-none")) {
                    searchInput.focus();
                }

            });

            // Search User
            searchInput.addEventListener("keyup", function() {

                let value = this.value.toLowerCase();

                userItems.forEach(function(item) {

                    let text = item.innerText.toLowerCase();

                    if (text.includes(value)) {
                        item.style.display = "block";
                    } else {
                        item.style.display = "none";
                    }

                });

            });

            // Select User
            userItems.forEach(function(item) {

                item.addEventListener("click", function() {

                    let userId = this.dataset.id;
                    let userName = this.dataset.name;

                    selectedText.innerText = userName;
                    hiddenInput.value = userId;

                    dropdownBox.classList.add("d-none");

                });

            });

            // Close Outside Click
            document.addEventListener("click", function(e) {

                if (!e.target.closest(".custom-dropdown")) {
                    dropdownBox.classList.add("d-none");
                }

            });

        });
    </script>
@endsection
