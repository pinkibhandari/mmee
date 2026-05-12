@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>Site List</strong></h6>

            <a href="{{ route('admin.sites.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add Site
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
                        <th>Site Name</th>
                        <th>Address</th>
                        <th>Created At</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse($sites as $site)
                        <tr>
                            <td>{{ $sites->firstItem() + $loop->index }}</td>
                            <td>{{ $site->site_name }}</td>
                            <td>{{ $site->address }}</td>
                            <td>{{ $site->created_at->format('d M Y') }}</td>

                            <!-- Status -->
                            <td>
                                @if ($site->status == 1)
                                    <span class="badge bg-success px-3 py-2 text-white">Active</span>
                                @else
                                    <span class="badge bg-danger px-3 py-2 text-white">Inactive</span>
                                @endif
                            </td>

                            <!-- Action -->
                            <td>
                                <div class="dropdown">

                                    <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                        data-bs-toggle="dropdown">

                                        <i class="ri-more-2-line"></i>

                                    </button>

                                    <ul class="dropdown-menu dropdown-menu-end">

                                        <!-- Edit -->
                                        <li>
                                            <a class="dropdown-item" href="{{ route('admin.sites.edit', $site->id) }}">

                                                <i class="ri-pencil-line me-2"></i>
                                                Edit

                                            </a>
                                        </li>

                                        <!-- Delete -->
                                        <li>
                                            <form action="{{ route('admin.sites.destroy', $site->id) }}" method="POST">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit" class="dropdown-item text-danger"
                                                    onclick="return confirm('Are you sure you want to delete this site?')">

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
                            <td colspan="6">No sites found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>

            <!-- Pagination -->
            <div class="mt-3">
                {{ $sites->links('vendor.pagination.custom') }}
            </div>

        </div>
    </div>
@endsection
