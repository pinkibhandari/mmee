@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>User List</strong></h6>

            @can('can_create_users')
                <a href="{{ route('admin.users.create') }}" class="btn btn-sm btn-primary">
                    <i class="fas fa-plus me-1"></i> Add User
                </a>
            @endcan
        </div>

        <!-- Success Message -->
        <div class="px-3 pt-3">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
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
                        <th>Email</th>
                        <th>Role</th>
                        <th>Created At</th>

                        @canany(['can_edit_users','can_delete_users'])
                            <th width="150">Action</th>
                        @endcanany
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse($users as $user)
                        <tr>
                            <td>{{ $users->firstItem() + $loop->index }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>

                            <!-- Role -->
                            <td>
                                @if($user->roles->count())
                                    <span class="badge bg-info px-3 py-2 text-white">
                                        {{ $user->roles->pluck('name')->implode(', ') }}
                                    </span>
                                @else
                                    <span class="badge bg-secondary">No Role</span>
                                @endif
                            </td>

                            <td>{{ $user->created_at->format('d M Y') }}</td>

                            @canany(['can_edit_users','can_delete_users'])
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    @can('can_edit_users')
                                        <a href="{{ route('admin.users.edit', $user->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                    @endcan

                                    @can('can_delete_users')
                                        <form action="{{ route('admin.users.destroy', $user->id) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure?')">

                                            @csrf
                                            @method('DELETE')

                                            <button class="btn btn-sm btn-outline-danger">
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
                            <td colspan="6">No users found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $users->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>
@endsection