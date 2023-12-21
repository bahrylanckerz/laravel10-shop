@php
    $segments = Request::segments();
@endphp
<ul class="navbar-nav bg-gradient-danger sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.dashboard') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ $segments[1] == 'dashboard' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('admin.dashboard') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span>
        </a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider">
    <!-- Heading -->
    <div class="sidebar-heading">
        Main Menu
    </div>
    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ $segments[1] == 'category' || $segments[1] == 'subcategory' ? 'active' : null }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseCategory"
            aria-expanded="true" aria-controls="collapseCategory">
        <i class="fas fa-fw fa-cog"></i>
        <span>Categories</span>
        </a>
        <div id="collapseCategory" class="collapse {{ $segments[1] == 'category' || $segments[1] == 'subcategory' ? 'show' : null }}" aria-labelledby="headingCategory" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ $segments[1] == 'category' ? 'active' : null }}" href="{{ route('admin.category') }}">Category</a>
                <a class="collapse-item {{ $segments[1] == 'subcategory' ? 'active' : null }}" href="{{ route('admin.subcategory') }}">Sub Category</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ $segments[1] == 'brand' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('admin.brand') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Brands</span></a>
    </li>
    <li class="nav-item {{ $segments[1] == 'product' ? 'active' : null }}">
        <a class="nav-link" href="{{ route('admin.product') }}">
        <i class="fas fa-fw fa-table"></i>
        <span>Products</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">
    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>