<!doctype html>

<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default"
    data-assets-path="{{ asset('assets') . '/' }}" data-template="vertical-menu-template" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>@yield('title')</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&ampdisplay=swap"
        rel="stylesheet" />

    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/iconify-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/nouislider/nouislider.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/front-page-landing.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/notyf/notyf.css') }}">
    <!-- Vendors CSS -->
    @yield('vendor-css')
    <!-- Page CSS -->
    @yield('page-css')
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('assets/js/front-config.js') }}"></script>
    <style>
        /* Force text to be dark */
        .notyf__message {
            color: #7367f0;
            !important;

            /* dark gray text */
        }

        .whatsapp-float {
            position: fixed;
            width: 60px;
            height: 60px;
            bottom: 20px;
            right: 20px;
            background-color: #ffffff;
            /* White background */
            color: #25d366;
            /* WhatsApp green */
            border-radius: 50%;
            text-align: center;
            font-size: 28px;
            box-shadow: 2px 2px 10px rgba(0, 0, 0, 0.2);
            z-index: 1000;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: transform 0.3s ease, background-color 0.3s ease;
        }

        .whatsapp-float:hover {
            transform: scale(1.1);
            background-color: #f1f1f1;
            /* Light gray hover */
            color: #20b955;
            /* Darker green icon */
        }
    </style>
</head>

<body>
    <script src="{{ asset('assets/vendor/js/dropdown-hover.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/mega-dropdown.js') }}"></script>
    <!-- Navbar: Start -->
    @include('frontend.layouts.nav')
    <!-- Navbar: End -->
    <!-- Sections:Start -->
    <!-- Floating WhatsApp Button -->
    <a href="https://wa.me/923425304093" target="_blank" class="whatsapp-float">
        <i class="icon-base ti tabler-brand-whatsapp icon-xl"></i>
    </a>



    @yield('content')

    <!-- / Sections:End -->

    <!-- Footer: Start -->
    @include('frontend.layouts.footer')
    <!-- Footer: End -->

    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/nouislider/nouislider.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/js/front-main.js') }}"></script>
    <script src="{{ asset('assets/js/front-page-landing.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/notyf/notyf.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <!-- Vendors JS -->
    @yield('vendor-js')
    <!-- Page JS -->
    @yield('page-js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const notyf = new Notyf({
                types: [{
                        type: 'success',
                        background: '#fff', // always white
                        icon: {
                            className: 'notyf__icon--success',
                            tagName: 'i',
                            color: '#28a745' // green icon
                        }
                    },
                    {
                        type: 'error',
                        background: '#fff', // always white
                        icon: {
                            className: 'notyf__icon--error',
                            tagName: 'i',
                            color: '#dc3545' // red icon
                        }
                    }
                ]
            });

            @if (session('success'))
                notyf.success("{{ session('success') }}");
            @endif

            @if (session('error'))
                notyf.error("{{ session('error') }}");
            @endif


            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notyf.error("{{ $error }}");
                @endforeach
            @endif
        });
    </script>
</body>

</html>
