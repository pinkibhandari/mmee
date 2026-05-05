@extends('admin.layouts.app')

@section('content')
    <div class="card shadow mb-4">

        <!-- Card Header -->
        <div class="card-header d-flex justify-content-between align-items-center">
            <h6 class="mb-0"><strong>Assign Task</strong></h6>
            <a href="{{ route('admin.tasks.index') }}" class="btn btn-outline-secondary px-4">
                Back
            </a>
        </div>

        <!-- Card Body -->
        <div class="card-body">

            <form action="#" method="POST">
                @csrf

                <div class="row">

                    <!-- Select Employee -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Select Employee</label>
                        <select name="employee" class="form-control select2-single">
                            <option value="">Select Employee</option>
                            <option value="1">John Doe</option>
                            <option value="2">Rahul Sharma</option>
                            <option value="3">Amit Kumar</option>
                        </select>
                    </div>

                    <!-- Select Address -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Select Address</label>
                        <select name="address" class="form-control select2-single">
                            <option value="">Select Address</option>
                            <option value="Delhi">Delhi</option>
                            <option value="Mumbai">Mumbai</option>
                            <option value="Lucknow">Lucknow</option>
                        </select>
                    </div>

                    <!-- Assign Date -->
                    <div class="col-md-4 mb-3">
                        <label class="form-label">Assign Date</label>
                        <input type="date" name="assign_date" class="form-control">
                    </div>

                </div>

                <!-- Buttons -->
                <div class="mt-3">
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="fas fa-save me-1"></i> Save
                    </button>

                </div>

            </form>

        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('.select2-single').select2({
                width: '100%'
            });
        });
    </script>
@endpush
