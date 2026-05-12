@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>Task List</strong></h6>
            <a href="{{ route('admin.tasks.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add Task
            </a>
        </div>

        <!-- Success Message -->
        <div class="px-3 pt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif
        </div>

        <!-- Status Tabs -->
        <div class="px-3 pt-2">

            <nav class="status-tabs">
                <!-- Pending Tab -->
                <a href="{{ route('admin.tasks.index', ['status' => 'pending']) }}"
                    class="status-tab-item {{ $status === 'pending' ? 'active' : '' }}">
                    Pending
                    <span class="tab-count badge-pending">{{ $pendingCount }}</span>
                </a>
                <!-- Assigned Tab -->
                <a href="{{ route('admin.tasks.index', ['status' => 'assigned']) }}"
                    class="status-tab-item {{ $status === 'assigned' ? 'active' : '' }}">
                    Assigned
                    <span class="tab-count badge-assigned">{{ $assignedCount }}</span>
                </a>

                <!-- In Progress Tab -->
                <a href="{{ route('admin.tasks.index', ['status' => 'in_progress']) }}"
                    class="status-tab-item {{ $status === 'in_progress' ? 'active' : '' }}">
                    In Progress
                    <span class="tab-count badge-in-progress">{{ $inProgressCount }}</span>
                </a>

                <!-- Completed Tab -->
                <a href="{{ route('admin.tasks.index', ['status' => 'completed']) }}"
                    class="status-tab-item {{ $status === 'completed' ? 'active' : '' }}">
                    Completed
                    <span class="tab-count badge-completed">{{ $completedCount }}</span>
                </a>

            </nav>

        </div>

        <!-- Card Body -->
        <div class="card-body table-responsive pt-2">

            <table class="table table-bordered table-hover align-middle">
                <thead class="thead-light text-center">
                    <tr>
                        <th>#</th>
                        <th>Task Code</th>
                        <th>Task Name</th>
                        <th>Assign To</th>
                        <th>Address</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse ($tasks as $task)
                        <tr>
                            <!-- Pagination serial number -->
                            <td>{{ $tasks->firstItem() + $loop->index }}</td>

                            <td>{{ $task->task_code }}</td>
                            <td>{{ $task->task_name }}</td>
                            <td>{{ $task->employee->name ?? 'N/A' }}</td>
                            <td>{{ $task->address ?? '-' }}</td>

                            <!-- Status -->
                            <td>

                                @if ($task->status == 'pending')
                                    <span class="badge bg-danger text-white px-3 py-2">
                                        Pending
                                    </span>
                                @elseif ($task->status == 'assigned')
                                    <span class="badge bg-primary text-white px-3 py-2">
                                        Assigned
                                    </span>
                                @elseif($task->status == 'in_progress')
                                    <span class="badge bg-warning text-white px-3 py-2">
                                        In Progress
                                    </span>
                                @elseif($task->status == 'completed')
                                    <span class="badge bg-success text-white px-3 py-2">
                                        Completed
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">
                                        N/A
                                    </span>
                                @endif

                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="dropdown">

                                    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                        data-bs-toggle="dropdown">

                                        <i class="ri-more-2-line"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        <!-- View -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.tasks.show', $task->id) }}">

                                                <i class="ri-eye-line me-2"></i>
                                                Details

                                            </a>
                                        </li>

                                        <!-- Edit -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.tasks.edit', $task->id) }}">

                                                <i class="ri-pencil-line me-2"></i>
                                                Edit

                                            </a>
                                        </li>

                                        <!-- Delete -->
                                        <li>
                                            <form action="{{ route('admin.tasks.destroy', $task->id) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this task?')">

                                                    <i class="ri-delete-bin-6-line me-2"></i>
                                                    Delete

                                                </button>

                                            </form>
                                        </li>

                                    </ul>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7">
                                No {{ ucfirst(str_replace('_', ' ', $status)) }} Tasks Found
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $tasks->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>
@endsection
