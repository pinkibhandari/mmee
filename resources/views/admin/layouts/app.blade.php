<!DOCTYPE html>
<html lang="en">

<head>
    @include('admin.includes.head')
</head>

<body id="page-top">
<div id="wrapper">

    <!-- Sidebar -->
    @include('admin.includes.sidebar')

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">

        <!-- Main Content -->
        <div id="content">

            <!-- Navbar -->
            @include('admin.includes.navbar')

            <!-- Page Content -->
            <div class="container-fluid mt-3">
                @yield('content')
            </div>

        </div>

        <!-- Footer -->
        @include('admin.includes.footer')

    </div>
</div>

<!-- Scroll to Top -->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>

<!-- Scripts -->
<script>
    setTimeout(function () {
        let alert = document.querySelector('.alert');
        if (alert) {
            let bsAlert = new bootstrap.Alert(alert);
            bsAlert.close();
        }
    }, 2000); // 3 seconds
</script>
<script src="{{ asset('admin/vendor/jquery/jquery.min.js') }}"></script>
<script src="{{ asset('admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>
<script src="{{ asset('admin/js/ruang-admin.min.js') }}"></script>
<script src="{{ asset('admin/vendor/chart.js/Chart.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/quill@1.3.7/dist/quill.min.js"></script>


@stack('scripts')

</body>
</html>