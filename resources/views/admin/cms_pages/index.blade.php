@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header">

            <div class="d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3">

                <!-- Title -->
                <h6 class="mb-0">
                    <strong>CMS Pages List</strong>
                </h6>

                <!-- Right Side -->
                <div class="d-flex flex-column flex-md-row align-items-stretch align-items-md-center gap-2">

                    <!-- Search Form -->
                    <form method="GET" action="{{ route('admin.cms-pages.index') }}"
                        class="d-flex flex-column flex-sm-row align-items-stretch align-items-sm-center gap-2">

                        <!-- Search -->
                        <div class="d-flex align-items-center gap-2">

                            <span class="small fw-semibold d-none d-sm-inline">
                                Search:
                            </span>

                            <input type="search" name="search" value="{{ request('search') }}"
                                class="form-control form-control-sm" placeholder="Search pages...">

                        </div>

                        <!-- Status -->
                        <select name="status" class="form-select form-select-sm">

                            <option value="">Status</option>

                            <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                        <!-- Search Button -->
                        <button class="btn btn-primary btn-sm" title="Search Filters">

                            <i class="ri-search-line"></i>

                        </button>

                        <!-- Reset -->
                        <a href="{{ route('admin.cms-pages.index') }}" class="btn btn-outline-secondary btn-sm"
                            title="Reset Filters">

                            <i class="ri-refresh-line"></i>

                        </a>

                    </form>

                    <!-- Add Button -->
                    <a href="{{ route('admin.cms-pages.create') }}" class="btn btn-primary btn-sm text-nowrap">

                        <i class="ri-add-line me-1"></i>
                        Add

                    </a>

                </div>

            </div>

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
        <div class="card-body pt-2">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="thead-light text-center">

                        <tr>
                            <th width="70">#</th>
                            <th>Title</th>
                            <th>Slug</th>
                            <th width="120">Status</th>
                            <th width="120">Action</th>
                        </tr>

                    </thead>

                    <tbody class="text-center">

                        @forelse($pages as $page)
                            <tr>

                                <!-- Serial No -->
                                <td>
                                    {{ $pages->firstItem() + $loop->index }}
                                </td>

                                <!-- Title -->
                                <td class="text-break">
                                    {{ $page->title }}
                                </td>

                                <!-- Slug -->
                                <td class="text-break">
                                    {{ $page->slug }}
                                </td>

                                <!-- Status -->
                                <td>

                                    @if ($page->status == 1)
                                        <span class="badge bg-success text-white px-3 py-2">
                                            Active
                                        </span>
                                    @else
                                        <span class="badge bg-secondary text-white px-3 py-2">
                                            Inactive
                                        </span>
                                    @endif

                                </td>

                                <!-- Actions -->
                                <td>

                                    <div class="dropdown">

                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill"
                                            data-bs-toggle="dropdown">

                                            <i class="ri-more-2-line"></i>

                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end">

                                            <!-- Edit -->
                                            <li>

                                                <a class="dropdown-item"
                                                    href="{{ route('admin.cms-pages.edit', $page->id) }}">

                                                    <i class="ri-pencil-line me-2"></i>
                                                    Edit

                                                </a>

                                            </li>

                                            <!-- Delete -->
                                            <li>

                                                <form action="{{ route('admin.cms-pages.destroy', $page->id) }}"
                                                    method="POST">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit" class="dropdown-item text-danger"
                                                        onclick="return confirm('Delete this page?')">

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

                                <td colspan="5" class="text-center py-4">

                                    No CMS Pages Found

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            <!-- Pagination -->
            <div class="px-2 pt-2">

                {{ $pages->links('vendor.pagination.custom') }}

            </div>

        </div>

    </div>
@endsection
