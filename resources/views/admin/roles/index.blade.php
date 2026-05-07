@extends('admin.layouts.app')

@section('content')

@can('can_view_roles')
<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between align-items-center">
        <h6><strong>Role List</strong></h6>

        @can('can_create_roles')
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Role
            </a>
        @endcan
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Role Name</th>
                    <th>Permissions</th>

                    @canany(['can_edit_roles','can_delete_roles'])
                        <th width="150">Action</th>
                    @endcanany
                </tr>
            </thead>

            <tbody>
                @forelse($roles as $key => $role)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $role->name }}</td>

                    <td>
                        @foreach($role->permissions as $perm)
                            <span class="badge bg-info">{{ $perm->name }}</span>
                        @endforeach
                    </td>

                    @canany(['can_edit_roles','can_delete_roles'])
                    <td>

                        @can('can_edit_roles')
                            <a href="{{ route('admin.roles.edit', $role->id) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        @endcan

                        @can('can_delete_roles')
                            <form action="{{ route('admin.roles.destroy', $role->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this role?')">
                                    Delete
                                </button>
                            </form>
                        @endcan

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

    </div>
</div>
@else
    <div class="alert alert-danger">
        You don't have permission to view roles.
    </div>
@endcan

@endsection