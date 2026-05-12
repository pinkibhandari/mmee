@extends('admin.layouts.app')

@section('content')

@can('can_view_roles')

<div class="card shadow mb-4">

    <!-- Card Header -->
    <div class="card-header d-flex justify-content-between align-items-center">
        <h6 class="mb-0"><strong>Role List</strong></h6>

        @can('can_create_roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add Role
            </a>
        @endcan
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
                    <th>Role Name</th>
                    <th>Permissions</th>

                    @canany(['can_edit_roles','can_delete_roles'])
                        <th width="150">Action</th>
                    @endcanany
                </tr>
            </thead>

            <tbody class="text-center">

                @forelse($roles as $role)
                    <tr>

                        <td>{{ $roles->firstItem() + $loop->index }}</td>
                        <td>{{ $role->name }}</td>

                        <td>
                            @foreach($role->permissions as $perm)
                                <span class="badge bg-info text-white px-2 py-1">
                                    {{ $perm->name }}
                                </span>
                            @endforeach
                        </td>

                        @canany(['can_edit_roles','can_delete_roles'])
                        <td>
                            <div class="d-flex justify-content-center gap-2">

                                @can('can_edit_roles')
                                    <a href="{{ route('admin.roles.edit', $role->id) }}"
                                       class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                @endcan

                                @can('can_delete_roles')
                                    <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Delete this role?')">

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
                        <td colspan="4">No roles found</td>
                    </tr>
                @endforelse

            </tbody>

        </table>

        <!-- Pagination -->
        <div class="mt-3">
            {{ $roles->links('vendor.pagination.custom') }}
        </div>

    </div>
</div>

@else
    <div class="alert alert-danger">
        You don't have permission to view roles.
    </div>
@endcan

@endsection