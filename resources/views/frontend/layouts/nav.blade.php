<nav class="py-0 shadow-none layout-navbar">
    <div class="container">
        <div class="px-3 navbar navbar-expand-lg landing-navbar px-md-8">
            <!-- Menu logo wrapper: Start -->
            <div class="py-0 navbar-brand app-brand demo d-flex me-4 me-xl-8 ms-0">
                <!-- Mobile menu toggle: Start-->
                <button class="px-0 border-0 navbar-toggler me-4" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                    aria-label="Toggle navigation">
                    <i class="align-middle icon-base ti tabler-menu-2 icon-lg text-heading fw-medium"></i>
                </button>
                <!-- Mobile menu toggle: End-->
                <a href="{{ route('home') }}" class="app-brand-link">
                    <span class="app-brand-logo demo">
                        <span class="text-primary">
                            <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                    fill="currentColor" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                    fill="#161616" />
                                <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                    d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                    fill="#161616" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                    fill="currentColor" />
                            </svg>
                        </span>
                    </span>
                    <span class="app-brand-text demo menu-text fw-bold ms-2 ps-1">HiveHomes</span>
                </a>
            </div>
            <!-- Menu logo wrapper: End -->
            <!-- Menu wrapper: Start -->
            <div class="collapse navbar-collapse landing-nav-menu" id="navbarSupportedContent">
                <button class="top-0 p-2 border-0 navbar-toggler text-heading position-absolute end-0 scaleX-n1-rtl"
                    type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
                    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="icon-base ti tabler-x icon-lg"></i>
                </button>
                <ul class="navbar-nav me-auto">
                    {{-- Home --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->routeIs('home') ? 'active' : '' }}"
                            href="{{ route('home') }}">
                            Home
                        </a>
                    </li>
                    {{-- FAQ --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->is('faq') ? 'active' : '' }}"
                            href="{{ route('faq') }}"> FAQ
                        </a>
                    </li>

                    {{-- Contact Us --}}
                    <li class="nav-item">
                        <a class="nav-link fw-medium {{ request()->is('contact-us') ? 'active' : '' }}"
                            href="{{ route('contact') }}">
                            Contact Us
                        </a>
                    </li>

                    @auth
                        @if (auth()->user()->is_active === 'active')
                            {{-- Products --}}
                            <li class="nav-item">
                                <a class="nav-link fw-medium {{ request()->routeIs('products.*') ? 'active' : '' }}"
                                    href="{{ route('products.index') }}">
                                    Products
                                </a>
                            </li>

                            {{-- Posts --}}
                            <li class="nav-item">
                                <a class="nav-link fw-medium {{ request()->routeIs('posts.*') ? 'active' : '' }}"
                                    href="{{ route('posts.index') }}">
                                    Posts
                                </a>
                            </li>

                            {{-- Services --}}
                            <li class="nav-item">
                                <a class="nav-link fw-medium {{ request()->routeIs('service-providers.*') ? 'active' : '' }}"
                                    href="{{ route('service-providers.index') }}">
                                    Services
                                </a>
                            </li>
                        @endif
                        {{-- Profile --}}
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('profile.show') }}">Profile</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('user.dashboard') }}">Dashboard</a>
                        </li>

                    @endauth


                    @php
                        $user = auth()->user();
                    @endphp

                    @if ($user && ($user->hasRole('society_admin') || $user->hasRole('super_admin')))
                        <li class="nav-item">
                            <a class="nav-link fw-medium" href="{{ route('dashboard') }}">Admin</a>
                        </li>
                    @endif


                </ul>
            </div>

            <div class="landing-menu-overlay d-lg-none"></div>
            <!-- Menu wrapper: End -->
            <!-- Toolbar: Start -->
            <ul class="flex-row navbar-nav align-items-center ms-auto">

                <!-- navbar button: Start -->
                @guest
                    <li>
                        <a href="{{ route('login') }}" class="btn btn-primary">
                            <span class="tf-icons icon-base ti tabler-login scaleX-n1-rtl me-md-1"></span>
                            <span class="d-none d-md-block">Login/Register</span>
                        </a>
                    </li>
                @else
                    {{-- Logout Button --}}
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger">
                                <span class="tf-icons icon-base ti tabler-logout scaleX-n1-rtl me-md-1"></span>
                                <span class="d-none d-md-block">Logout</span>
                            </button>
                        </form>
                    </li>
                @endguest
                <!-- navbar button: End -->

            </ul>

            <!-- Toolbar: End -->
        </div>
    </div>
</nav>
