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
                        <td>{{ $task->assign_to ?? 'N/A' }}</td>
                        <td>{{ $task->address ?? '-' }}</td>

                        <!-- Status -->
                        <td>
                            @if ($task->status == 0)
                                <span class="badge bg-warning text-dark px-3 py-2">Pending</span>
                            @else
                                <span class="badge bg-success px-3 py-2">Completed</span>
                            @endif
                        </td>

                        <!-- Actions -->
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                <!-- Edit -->
                                <a href="{{ route('admin.tasks.edit', $task->id) }}"
                                   class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>

                                <!-- Delete -->
                                <form action="{{ route('admin.tasks.destroy', $task->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')

                                    <button class="btn btn-sm btn-outline-danger" title="Delete">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                            </div>
                        </td>
                    </tr>

                @empty
                    <tr>
                        <td colspan="7">No Tasks Found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

        <!-- Pagination -->
        <div class="mt-3 d-flex justify-content-end">
            {{ $tasks->links() }}
        </div>

    </div>
</div>
@endsection