<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3   bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0" href=" https://demos.creative-tim.com/material-dashboard/pages/dashboard "
            target="_blank">
            <img src="{{ asset('admin/assets/img/logo-ct.png') }}" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-1 font-weight-bold text-white">{{ auth()->user()->name }}</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto  max-height-vh-100" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ request()->routeis('admin.dashboard') ? 'active bg-gradient-primary' : '' }}"
                    href="{{ route('admin.dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>

            @can('show-role')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.role.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.role.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">table_view</i>
                        </div>
                        <span class="nav-link-text ms-1">Roles</span>
                    </a>
                </li>
            @endcan

            @can('show-user')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.user.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.user.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">receipt_long</i>
                        </div>
                        <span class="nav-link-text ms-1">Users</span>
                    </a>
                </li>
            @endcan

            @can('show-category')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.category.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.category.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">format_textdirection_r_to_l</i>
                        </div>
                        <span class="nav-link-text ms-1">Categories</span>
                    </a>
                </li>
            @endcan

            @can('show-product')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.product.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.product.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Products</span>
                    </a>
                </li>
            @endcan

            @can('show-coupon')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.coupon.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.coupon.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Coupon</span>
                    </a>
                </li>
            @endcan

            @can('show-order')
                <li class="nav-item">
                    <a class="nav-link text-white {{ request()->routeis('admin.order.*') ? 'active bg-gradient-primary' : '' }}"
                        href="{{ route('admin.order.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">view_in_ar</i>
                        </div>
                        <span class="nav-link-text ms-1">Order</span>
                    </a>
                </li>
            @endcan
        </ul>
    </div>
</aside>
