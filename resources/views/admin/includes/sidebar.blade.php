    <ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
            <div class="sidebar-brand-icon">
                <img src="{{ asset('admin/img/logo/logo.png') }}">
            </div>
            <div class="sidebar-brand-text mx-3">MME_ADMIN</div>
        </a>
        <hr class="sidebar-divider my-0">
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
        <hr class="sidebar-divider">
        {{-- <div class="sidebar-heading">
        Features
      </div> --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseUsers"
                aria-expanded="true" aria-controls="collapseUsers">
                <i class="fas fa-users"></i>
                <span>User Management</span>
            </a>

            <div id="collapseUsers" class="collapse" aria-labelledby="headingUsers" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <!-- Users -->
                    {{-- <a class="collapse-item" href="{{ route('admin.users.index') }}">
                <i class="fas fa-user me-2"></i> Users 
            </a> --}}

                    @can('can_view_users')
                        <a class="collapse-item" href="{{ route('admin.users.index') }}">
                            <i class="fas fa-user me-2"></i> Users
                        </a>
                    @endcan
                    <!-- Roles -->
                    {{-- <a class="collapse-item" href="{{ route('admin.roles.index') }}">
                 <i class="fas fa-user-tag me-2"></i> Roles
            </a> --}}
                    @can('can_view_roles')
                        <a class="collapse-item" href="{{ route('admin.roles.index') }}">
                            <i class="fas fa-user-tag me-2"></i> Roles
                        </a>
                    @endcan
                    <!-- Permissions -->
                    {{-- <a class="collapse-item" href="{{ route('admin.permissions.index') }}">
                <i class="fas fa-key me-2"></i> Permissions
            </a> --}}
                    @can('can_view_permission')
                        <a class="collapse-item" href="{{ route('admin.permissions.index') }}">
                            <i class="fas fa-key me-2"></i> Permissions
                        </a>
                    @endcan
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                aria-expanded="true" aria-controls="collapseBootstrap">
                <i class="far fa-fw fa-window-maximize"></i>
                <span>Task Managements</span>
            </a>
            <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap"
                data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- <a class="collapse-item" href="{{ route('admin.tasks.create') }}"><i
                            class="fas fa-plus-circle me-2"></i> Assigned Task</a> --}}
                    <a class="collapse-item" href="{{ route('admin.tasks.index') }}">
                        <i class="fas fa-list me-2"></i> Task List
                    </a>
                </div>

            </div>
        </li>

        {{-- Site Management --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseSite"
                aria-expanded="true" aria-controls="collapseSite">
                <i class="fas fa-globe"></i>
                <span>Site Management</span>
            </a>

            <div id="collapseSite" class="collapse" aria-labelledby="headingSite" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('admin.sites.index') }}">
                        <i class="fas fa-list me-2"></i> Site List
                    </a>

                </div>

            </div>
        </li>
        {{-- CMS Pages --}}
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCms"
                aria-expanded="true" aria-controls="collapseCms">

                <i class="fas fa-file-alt"></i>

                <span>CMS Management</span>

            </a>

            <div id="collapseCms" class="collapse" aria-labelledby="headingCms" data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('admin.cms-pages.index') }}">

                        <i class="fas fa-list me-2"></i>
                        CMS Page List

                    </a>

                </div>

            </div>

        </li>
        {{-- Attendance --}}
        <li class="nav-item">

            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseAttendance"
                aria-expanded="true" aria-controls="collapseAttendance">

                <i class="fas fa-calendar-check"></i>

                <span>Attendance Management</span>

            </a>

            <div id="collapseAttendance" class="collapse" aria-labelledby="headingAttendance"
                data-parent="#accordionSidebar">

                <div class="bg-white py-2 collapse-inner rounded">

                    <a class="collapse-item" href="{{ route('admin.attendance.index') }}">

                        <i class="fas fa-list me-2"></i>
                        Attendance List

                    </a>

                </div>

            </div>

        </li>
        {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseForm" aria-expanded="true"
          aria-controls="collapseForm">
          <i class="fab fa-fw fa-wpforms"></i>
          <span>Forms</span>
        </a>
        <div id="collapseForm" class="collapse" aria-labelledby="headingForm" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Forms</h6>
            <a class="collapse-item" href="form_basics.html">Form Basics</a>
            <a class="collapse-item" href="form_advanceds.html">Form Advanceds</a>
          </div>
        </div>
      </li> --}}
        {{-- <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTable" aria-expanded="true"
          aria-controls="collapseTable">
          <i class="fas fa-fw fa-table"></i>
          <span>Tables</span>
        </a>
        <div id="collapseTable" class="collapse" aria-labelledby="headingTable" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            <h6 class="collapse-header">Tables</h6>
            <a class="collapse-item" href="simple-tables.html">Simple Tables</a>
            <a class="collapse-item" href="datatables.html">DataTables</a>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="ui-colors.html">
          <i class="fas fa-fw fa-palette"></i>
          <span>UI Colors</span>
        </a>
      </li> --}}

    </ul>
