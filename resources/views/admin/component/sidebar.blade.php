<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="#">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Library<sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ is_null(Request::segment(2))  ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/dashboard") }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Data
    </div>

    <li class="nav-item {{ Request::segment(2) == "books" ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/dashboard/book") }}">
            <i class="fa fa-book"></i>
            <span>List Books</span></a>
    </li>

    <li class="nav-item {{ Request::segment(2) == "author" ? "active" : ""  }}">
        <a class="nav-link" href="{{ url("/dashboard/author") }}">
            <i class="fa fa-shopping-basket"></i>
            <span>List Authors</span></a>
    </li>

    @role('super-admin')
        <li class="nav-item {{ Request::segment(2) == "user" ? "active" : ""  }}">
            <a class="nav-link" href="{{ url("/dashboard/user") }}">
                <i class="fa fa-shopping-bag"></i>
                <span>List Users</span></a>
        </li>
    @endrole

    <hr class="sidebar-divider">
</ul>
<!-- End of Sidebar -->
