@extends('admin.layouts.app')

@section('content')

@can('can_view_permission')
<div class="card shadow mb-4">

    <div class="card-header d-flex justify-content-between">
        <h6><strong>Permission List</strong></h6>

        @can('can_create_permission')
            <a href="{{ route('admin.permissions.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus"></i> Add Permission
            </a>
        @endcan
    </div>

    <div class="card-body table-responsive">

        <table class="table table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permission Name</th>

                    @canany(['can_edit_permission','can_delete_permission'])
                        <th width="150">Action</th>
                    @endcanany
                </tr>
            </thead>

            <tbody>
                @forelse($permissions as $key => $permission)
                <tr>
                    <td>{{ $key+1 }}</td>
                    <td>{{ $permission->name }}</td>

                    @canany(['can_edit_permission','can_delete_permission'])
                    <td>

                        @can('can_edit_permission')
                            <a href="{{ route('admin.permissions.edit', $permission->id) }}"
                               class="btn btn-sm btn-primary">
                                Edit
                            </a>
                        @endcan

                        @can('can_delete_permission')
                            <form action="{{ route('admin.permissions.destroy', $permission->id) }}"
                                  method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Delete this permission?')">
                                    Delete
                                </button>
                            </form>
                        @endcan

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
</div>
@else
    <div class="alert alert-danger">
        You don't have permission to view permissions.
    </div>
@endcan

@endsection