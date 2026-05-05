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
                        <th>Employee</th>
                        <th>Address</th>
                        <th>Assign Date</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    <!-- Row 1 -->
                    <tr>
                        <td>1</td>
                        <td>John Doe</td>
                        <td>Delhi</td>
                        <td>2026-05-05</td>
                        <td><span class="badge bg-warning text-dark px-3 py-2">Pending</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" title="Delete"
                                    onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 2 -->
                    <tr>
                        <td>2</td>
                        <td>Rahul Sharma</td>
                        <td>Mumbai</td>
                        <td>2026-05-06</td>
                        <td><span class="badge bg-success px-3 py-2">Completed</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <!-- Row 3 -->
                    <tr>
                        <td>3</td>
                        <td>Amit Kumar</td>
                        <td>Lucknow</td>
                        <td>2026-05-07</td>
                        <td><span class="badge bg-primary px-3 py-2">In Progress</span></td>
                        <td>
                            <div class="d-flex justify-content-center gap-2">
                                <a href="#" class="btn btn-sm btn-outline-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure?')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>

        </div>
    </div>
@endsection
