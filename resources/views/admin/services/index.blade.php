@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>Service List</strong></h6>

            <a href="{{ route('admin.services.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add Service
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

        <!-- Table -->
        <div class="card-body table-responsive pt-2">

            <table class="table table-bordered table-hover align-middle">
                <thead class="text-center thead-light">
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Created At</th>

                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse($services as $key => $service)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $service->name }}</td>
                            <td>{{ Str::limit($service->description, 50) }}</td>
                            <td>{{ $service->created_at->format('d M Y') }}</td>
                            <!-- Status Badge (Task Style Same) -->
                            <td>
                                @if ($service->status == 1)
                                    <span class="badge bg-success px-3 py-2 text-white">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 text-white">Inactive</span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <a href="{{ route('admin.services.edit', $service->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <form action="{{ route('admin.services.destroy', $service->id) }}" method="POST"
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
                            <td colspan="5">No services found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

        </div>
    </div>
@endsection
