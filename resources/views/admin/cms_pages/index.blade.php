@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>CMS Pages List</strong></h6>

            <a href="{{ route('admin.cms-pages.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus me-1"></i> Add Page
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
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Status</th>
                        <th width="150">Action</th>
                    </tr>
                </thead>

                <tbody class="text-center">

                    @forelse($pages as $page)
                        <tr>
                            <!-- Serial No -->
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $page->title }}</td>
                            <td>{{ $page->slug }}</td>

                            <!-- Status -->
                            <td>
                                @if ($page->status == 1)
                                    <span class="badge bg-success text-white px-3 py-2">
                                        Active
                                    </span>
                                @else
                                    <span class="badge bg-secondary px-3 py-2">
                                        Inactive
                                    </span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td>
                                <div class="d-flex justify-content-center gap-2">

                                    <!-- Edit -->
                                    <a href="{{ route('admin.cms-pages.edit', $page->id) }}"
                                        class="btn btn-sm btn-outline-primary" title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </a>

                                    <!-- Delete -->
                                    <form action="{{ route('admin.cms-pages.destroy', $page->id) }}" method="POST"
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
                            <td colspan="5">No CMS Pages Found</td>
                        </tr>
                    @endforelse

                </tbody>
            </table>


        </div>
    </div>
@endsection
