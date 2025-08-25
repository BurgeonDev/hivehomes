<aside id="layout-menu" class="layout-menu menu-vertical menu">
    <div class="app-brand demo">
        <a href="index.html" class="app-brand-link">
            <span class="app-brand-logo demo">
                <span class="text-primary">
                    <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                            fill="currentColor" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z" fill="#161616" />
                        <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                            d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z" fill="#161616" />
                        <path fill-rule="evenodd" clip-rule="evenodd"
                            d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                            fill="currentColor" />
                    </svg>
                </span>
            </span>
            <span class="app-brand-text demo menu-text fw-bold ms-3">HomeHives</span>
        </a>

        <a href="javascript:void(0);" class="layout-menu-toggle menu-link text-large ms-auto">
            <i class="icon-base ti menu-toggle-icon d-none d-xl-block"></i>
            <i class="icon-base ti tabler-x d-block d-xl-none"></i>
        </a>
    </div>

    <div class="menu-inner-shadow"></div>

    <ul class="py-1 menu-inner">

        <!-- Dashboard -->
        <li class="menu-item {{ request()->routeIs('dashboard') ? 'active open' : '' }}">
            <a href="{{ route('dashboard') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-smart-home"></i>
                <div data-i18n="Dashboard">Dashboard</div>
            </a>
        </li>

        <!-- ===== Management Section ===== -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Management">Management</span>
        </li>

        <li class="menu-item {{ request()->routeIs('roles.*') ? 'active open' : '' }}">
            <a href="{{ route('roles.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-settings"></i>
                <div data-i18n="Roles &amp; Permissions">Roles &amp; Permissions</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('users.*') ? 'active open' : '' }}">
            <a href="{{ route('users.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-users"></i>
                <div data-i18n="Users">Users</div>
            </a>
        </li>

        <!-- ===== Location Section ===== -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Location">Location</span>
        </li>

        <li class="menu-item {{ request()->routeIs('countries.*', 'states.*', 'cities.*') ? 'active open' : '' }}">
            <a href="javascript:void(0);" class="menu-link menu-toggle">
                <i class="menu-icon icon-base ti tabler-map"></i>
                <div data-i18n="Location">Location</div>
            </a>
            <ul class="menu-sub">
                <li class="menu-item {{ request()->routeIs('countries.*') ? 'active' : '' }}">
                    <a href="{{ route('countries.index') }}" class="menu-link">
                        <div data-i18n="Countries">Countries</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('states.*') ? 'active' : '' }}">
                    <a href="{{ route('states.index') }}" class="menu-link">
                        <div data-i18n="States">States</div>
                    </a>
                </li>
                <li class="menu-item {{ request()->routeIs('cities.*') ? 'active' : '' }}">
                    <a href="{{ route('cities.index') }}" class="menu-link">
                        <div data-i18n="Cities">Cities</div>
                    </a>
                </li>
            </ul>
        </li>

        <!-- ===== Content Section ===== -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Content">Content</span>
        </li>

        <li class="menu-item {{ request()->routeIs('societies.*') ? 'active open' : '' }}">
            <a href="{{ route('societies.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-building-skyscraper"></i>
                <div data-i18n="Societies">Societies</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.posts.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.posts.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-article"></i>
                <div data-i18n="Posts">Posts</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.post-categories.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.post-categories.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-category"></i>
                <div data-i18n="Post Categories">Post Categories</div>
            </a>
        </li>


        <li class="menu-item {{ request()->routeIs('admin.contacts.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.contacts.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-message-dots"></i>
                <div data-i18n="Contact Messages">Contact Messages</div>
            </a>
        </li>

        <!-- ===== Service Provider Section ===== -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Service Providers">Service Providers</span>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.types.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.types.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-list-check"></i>
                <div data-i18n=" Provider Types">Provider Types</div>
            </a>
        </li>
        <li class="menu-item {{ request()->routeIs('admin.service-providers.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.service-providers.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-tool"></i>
                <div data-i18n="Service Providers">Service Providers</div>
            </a>
        </li>

        <!-- ===== Products Section ===== -->
        <li class="menu-header small">
            <span class="menu-header-text" data-i18n="Products">Products</span>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.product-categories.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.product-categories.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-category"></i>
                <div data-i18n="Product Categories">Product Categories</div>
            </a>
        </li>

        <li class="menu-item {{ request()->routeIs('admin.products.*') ? 'active open' : '' }}">
            <a href="{{ route('admin.products.index') }}" class="menu-link">
                <i class="menu-icon icon-base ti tabler-box"></i>
                <div data-i18n="Products">Products</div>
            </a>
        </li>


    </ul>


</aside>

<div class="menu-mobile-toggler d-xl-none rounded-1">
    <a href="javascript:void(0);" class="p-2 layout-menu-toggle menu-link text-large text-bg-secondary rounded-1">
        <i class="ti tabler-menu icon-base"></i>
        <i class="ti tabler-chevron-right icon-base"></i>
    </a>
</div>
