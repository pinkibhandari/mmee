@extends('admin.layouts.app')

@section('content')

@can('can_view_permission')

<div class="card shadow mb-4">

    <!-- Success Message -->
    <div class="px-3 pt-3">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif
    </div>

    <!-- Header -->
    <div class="card-header">

        <div class="d-flex flex-wrap justify-content-between align-items-center gap-2">

            <!-- Title -->
            <h6 class="mb-0"><strong>Permission List</strong></h6>

            <!-- Actions -->
            <div class="d-flex flex-wrap align-items-center gap-2">

                <!-- Search -->
                <form method="GET"
                      action="{{ route('admin.permissions.index') }}"
                      class="d-flex flex-wrap align-items-center gap-2">

                    <span class="d-none d-sm-inline">Search:</span>

                    <input type="search"
                           name="search"
                           class="form-control form-control-sm"
                           placeholder="Search permission..."
                           value="{{ request('search') }}"
                           style="width:180px; max-width:100%;">

                    <button class="btn btn-primary btn-sm">
                        <i class="fas fa-search"></i>
                    </button>

                    <a href="{{ route('admin.permissions.index') }}"
                       class="btn btn-sm btn-outline-info"
                       title="Reset">

                        <i class="fas fa-sync-alt text-primary"></i>
                    </a>

                </form>

                <!-- Add Button -->
                @can('can_create_permission')
                    <a href="{{ route('admin.permissions.create') }}"
                       class="btn btn-sm btn-primary">
                        <i class="fas fa-plus me-1"></i>
                        <span class="d-none d-sm-inline">Add</span>
                    </a>
                @endcan

            </div>
        </div>
    </div>

    <hr class="my-0">

    <!-- TABLE -->
    <div class="table-responsive px-3 px-md-4 pb-3">

        <table class="table table-hover table-bordered align-middle text-center">
            <thead class="bg-light">
                <tr>
                    <th width="80">ID</th>
                    <th>Permission Name</th>

                    @canany(['can_edit_permission', 'can_delete_permission'])
                        <th width="150">Actions</th>
                    @endcanany
                </tr>
            </thead>

            <tbody>

                @forelse($permissions as $key => $permission)
                    <tr>

                        <td>{{ $permissions->firstItem() + $loop->index }}</td>

                        <td>
                            <span class="fw-semibold">
                                {{ $permission->name }}
                            </span>
                        </td>

                        @canany(['can_edit_permission', 'can_delete_permission'])
                        <td>
                            <div class="d-flex justify-content-center flex-wrap gap-2">

                                @can('can_edit_permission')
                                    <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                                       class="btn btn-sm btn-outline-primary"
                                       title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('can_delete_permission')
                                    <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this permission?')">

                                        @csrf
                                        @method('DELETE')

                                        <button class="btn btn-sm btn-outline-danger" title="Delete">
                                            <i class="fas fa-trash"></i>
                                        </button>

                                    </form>
                                @endcan

                            </div>
                        </td>
                        @endcanany

                    </tr>
                @empty
                    <tr>
                        <td colspan="3">No permissions found</td>
                    </tr>
                @endforelse

            </tbody>
        </table>

    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center justify-content-md-end px-3 px-md-4 pb-3">
        {{ $permissions->links('pagination::bootstrap-5') }}
    </div>

</div>

@else
    <div class="alert alert-danger">
        You don't have permission to view permissions.
    </div>
@endcan

@endsection