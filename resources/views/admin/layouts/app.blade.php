<!doctype html>

<html lang="en" class="layout-navbar-fixed layout-menu-fixed layout-wide" dir="ltr" data-skin="default"
    data-assets-path="{{ asset('assets') . '/' }}" data-template="vertical-menu-template" data-bs-theme="light">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
    <!-- Core CSS -->

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/node-waves/node-waves.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/pickr/pickr-themes.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/demo.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/flatpickr/flatpickr.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/notyf/notyf.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/animate-css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.css') }}">

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/apex-charts/apex-charts.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet"
        href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />

    <!-- Vendors CSS -->
    @yield('vendor-css')
    <!-- Page CSS -->
    @yield('page-css')
    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/js/template-customizer.js') }}"></script> --}}
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <style>
        .notyf {
            top: 1rem !important;
            right: 1rem !important;
            left: auto !important;
            z-index: 10850 !important;
        }

        /* single toast message appearance */
        .notyf__message {
            background: var(--bs-primary, #0d6efd) !important;
            color: #fff !important;
            border-radius: 0.5rem !important;
            padding: 0.75rem 1rem !important;
            box-shadow: 0 6px 18px rgba(13, 110, 253, 0.12) !important;
            font-weight: 500;
            display: flex;
            align-items: center;
        }

        .notyf__icon {
            font-size: 1.05rem;
            margin-right: 0.6rem;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

        .notyf__message.notyf__message--success,
        .notyf__message.notyf__message--error {
            background: var(--bs-primary, #0d6efd) !important;
        }

        .notyf__message * {
            color: #fff !important;
        }

        /* Optional: make dismiss (x) icon white too */
        .notyf__dismiss {
            color: #fff !important;
        }

        @media (max-width: 576px) {
            .notyf__message {
                padding: 0.6rem 0.75rem !important;
                font-size: 0.95rem;
            }
        }
    </style>
</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->

            @include('admin.layouts.sidebar')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->
                @include('admin.layouts.nav')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->
                    @yield('content')
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('admin.layouts.footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/popper/popper.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/node-waves/node-waves.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@algolia/autocomplete-js.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/pickr/pickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/hammer/hammer.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/i18n/i18n.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/flatpickr/flatpickr.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/notyf/notyf.js') }}"></script>
    <script src="{{ asset('assets/js/ui-toasts.js') }}"></script>
    <script src="{{ asset('assets/js/extended-ui-sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/sweetalert2/sweetalert2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/apex-charts/apexcharts.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    <!-- endbuild -->
    <!-- Vendors JS -->
    @yield('vendor-js')
    <!-- Page JS -->
    @yield('page-js')
    <script>
        /* init Notyf: primary background + per-type icon colors (JS fallback) */
        const notyf = new Notyf({
            position: {
                x: 'right',
                y: 'top'
            },
            duration: 5000,
            ripple: true,
            dismissible: true,
            types: [{
                    type: 'success',
                    background: 'var(--bs-primary, #0d6efd)', // keep primary bg
                    icon: {
                        className: 'notyf__icon--success',
                        tagName: 'i',
                        color: 'var(--bs-success, #198754)' // icon green
                    }
                },
                {
                    type: 'error',
                    background: 'var(--bs-primary, #0d6efd)',
                    icon: {
                        className: 'notyf__icon--error',
                        tagName: 'i',
                        color: 'var(--bs-danger, #dc3545)' // icon red
                    }
                }
            ]
        });

        document.addEventListener('DOMContentLoaded', function() {
            @if (session('success'))
                notyf.success("{{ addslashes(session('success')) }}");
            @endif

            @if (session('error'))
                notyf.error("{{ addslashes(session('error')) }}");
            @endif

            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    notyf.error("{{ addslashes($error) }}");
                @endforeach
            @endif
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.show-confirm').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            const tableTitle = $('.card-title').text().trim(); // Dynamic title from the page

            const table = $('.datatables-basic').DataTable({
                responsive: true,
                lengthChange: true,
                order: [
                    [1, 'asc']
                ],
                layout: {
                    topStart: {
                        rowClass: 'row mx-3 my-0 justify-content-between',
                        features: [{
                            pageLength: {
                                menu: [7, 10, 25, 50, 100],
                                text: 'Show _MENU_ entries'
                            }
                        }]
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Search...'
                        }
                    },
                    bottomStart: {
                        rowClass: 'row mx-3 justify-content-between',
                        features: ['info']
                    },
                    bottomEnd: 'paging'
                },
                displayLength: 7,
                language: {
                    paginate: {
                        next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                        previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                        first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                        last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                    }
                },
                buttons: [{
                        extend: 'csv',
                        title: tableTitle,
                        filename: tableTitle.replace(/\s+/g, '_') + "_" + new Date().toISOString()
                            .slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        } // exclude last col (Actions)
                    },
                    {
                        extend: 'excel',
                        title: tableTitle,
                        filename: tableTitle.replace(/\s+/g, '_') + "_" + new Date().toISOString()
                            .slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        title: tableTitle,
                        filename: tableTitle.replace(/\s+/g, '_') + "_" + new Date().toISOString()
                            .slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        title: tableTitle,
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ]
            });

            // Export triggers
            $('#export-csv').on('click', e => {
                e.preventDefault();
                table.button(0).trigger();
            });
            $('#export-excel').on('click', e => {
                e.preventDefault();
                table.button(1).trigger();
            });
            $('#export-pdf').on('click', e => {
                e.preventDefault();
                table.button(2).trigger();
            });
            $('#export-print').on('click', e => {
                e.preventDefault();
                table.button(3).trigger();
            });
        });
    </script>




</body>

</html>
