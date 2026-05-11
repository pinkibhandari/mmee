@extends('admin.layouts.app')

@section('content')

<div class="card shadow mb-4">

    <!-- Header -->
    <div class="card-header d-flex justify-content-between align-items-center">

        <h6 class="mb-0">
            <strong>Attendance List</strong>
        </h6>

        <!-- Status Filter -->
        <div>

            <select id="statusFilter"
                    class="form-select form-select-sm">

                <option value="">All Status</option>

                <option value="present">
                    Present
                </option>

                <option value="absent">
                    Absent
                </option>

            </select>

        </div>

    </div>

    <!-- Success Message -->
    <div class="px-3 pt-3">

        @if (session('success'))

            <div class="alert alert-success alert-dismissible fade show"
                 role="alert">

                {{ session('success') }}

                <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                </button>

            </div>

        @endif

    </div>

    <!-- Card Body -->
    <div class="card-body table-responsive pt-2">

        <table class="table table-bordered table-hover align-middle"
               id="attendanceTable">

            <thead class="thead-light text-center">

                <tr>
                    <th>#</th>
                    <th>User Name</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Created At</th>
                </tr>

            </thead>

            <tbody class="text-center">

                @forelse($attendances as $attendance)

                    <tr data-status="{{ strtolower($attendance->status) }}">

                        <!-- Serial Number -->
                        <td>
                            {{ $attendances->firstItem() + $loop->index }}
                        </td>

                        <!-- User -->
                        <td>
                            {{ $attendance->user->name ?? 'N/A' }}
                        </td>

                        <!-- Date -->
                        <td>
                            {{ \Carbon\Carbon::parse($attendance->date)->format('d-m-Y') }}
                        </td>

                        <!-- Status -->
                        <td>

                            @if ($attendance->status == 'present')

                                <span class="badge bg-success text-white px-3 py-2">
                                    Present
                                </span>

                            @elseif($attendance->status == 'absent')

                                <span class="badge bg-danger text-white px-3 py-2">
                                    Absent
                                </span>

                            @endif

                        </td>

                        <!-- Created At -->
                        <td>
                            {{ $attendance->created_at->format('d-m-Y h:i A') }}
                        </td>

                    </tr>

                @empty

                    <tr id="noDataRow">

                        <td colspan="5">
                            No Attendance Found
                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    <!-- Pagination -->
    <div class="d-flex justify-content-center justify-content-md-end px-3 px-md-4 pb-3">

        {{ $attendances->links('pagination::bootstrap-5') }}

    </div>

</div>

<!-- JS Filter -->
<script>
    document.addEventListener("DOMContentLoaded", function () {

        const statusFilter = document.getElementById("statusFilter");
        const rows = document.querySelectorAll("#attendanceTable tbody tr");

        statusFilter.addEventListener("change", function () {

            const selectedStatus = this.value.toLowerCase();

            let visibleRows = 0;

            rows.forEach(function (row) {

                const rowStatus = row.getAttribute("data-status");

                // Skip no data row
                if (!rowStatus) return;

                if (selectedStatus === "" || rowStatus === selectedStatus) {

                    row.style.display = "";
                    visibleRows++;

                } else {

                    row.style.display = "none";

                }

            });

        });

    });
</script>

@endsection