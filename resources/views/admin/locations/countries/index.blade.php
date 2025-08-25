@extends('admin.layouts.app')
@section('title', 'Countires')
@section('vendor-css')

    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />
@endsection

@section('content')

    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">
                    <a href="{{ route('home') }}">Home</a>
                </li>
                <li class="breadcrumb-item">
                    <a href="javascript:void(0);">Location</a>
                </li>
                <li class="breadcrumb-item active">Countires</li>
            </ol>
        </nav>


        <!-- Countries List Table -->
        <div class="card">
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="mt-0 d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
                    <h5 class="pb-6 mb-0 text-center card-title text-md-start pb-md-0">Countries</h5>
                </div>
                <div class="mt-0 d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto">
                    <div class="flex-wrap mb-0 dt-buttons btn-group">
                        <div class="btn-group">
                            <button class="btn buttons-collection btn-label-primary dropdown-toggle me-4" type="button"
                                id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="gap-2 d-flex align-items-center">
                                    <i class="icon-base ti tabler-upload icon-xs me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Export</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="exportDropdown">
                                <li><a class="dropdown-item" href="#" id="export-csv">CSV</a></li>
                                <li><a class="dropdown-item" href="#" id="export-excel">Excel</a></li>
                                <li><a class="dropdown-item" href="#" id="export-pdf">PDF</a></li>
                                <li><a class="dropdown-item" href="#" id="export-print">Print</a></li>
                            </ul>
                        </div>

                        <button class="btn create-new btn-primary" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasAddCountry" aria-controls="offcanvasAddCountry" type="button">
                            <span class="gap-2 d-flex align-items-center">
                                <i class="icon-base ti tabler-plus icon-sm"></i>
                                <span class="d-none d-sm-inline-block">Add Country</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Country Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($countries as $country)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $country->name }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info"
                                        onclick="editCountry({{ $country }})"> <i
                                            class="icon-base ti tabler-edit"></i></button>
                                    <form method="POST" action="{{ route('countries.destroy', $country) }}"
                                        class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm badge bg-label-danger show-confirm"> <i
                                                class="icon-base ti tabler-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <!-- Offcanvas for Add/Edit Country -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCountry"
                aria-labelledby="offcanvasAddCountryLabel">
                <div class="offcanvas-header border-bottom">

                    <h5 id="offcanvasTitle" class="offcanvas-title">Add Country</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
                    <form method="POST" id="countryForm">
                        @csrf
                        <input type="hidden" name="_method" id="countryFormMethod" value="POST">
                        <div class="mb-6">
                            <label class="form-label" for="country-name">Country Name</label>
                            <input type="text" name="name" class="form-control" id="country-name"
                                placeholder="Pakistan" required>
                        </div>
                        <button type="submit" class="btn btn-primary me-3" id="countryFormSubmit">Submit</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>



        </div>

    </div>
@endsection


@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection
@section('page-js')
    <script src="{{ asset('') }}assets/js/tables-datatables-basic.js"></script>


    <script>
        function editCountry(country) {
            // Set the form action to the correct route
            $('#countryForm').attr('action', '/countries/' + country.id);

            // Set method to PUT
            $('#countryFormMethod').val('PUT');

            // Set the country name
            $('#country-name').val(country.name);

            // Change title and button
            $('#offcanvasTitle').text('Edit Country');
            $('#countryFormSubmit').text('Update');

            // Show the offcanvas
            var offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCountry'));
            offcanvas.show();
        }

        // Optional: reset offcanvas when closing (for "Add")
        document.getElementById('offcanvasAddCountry').addEventListener('hidden.bs.offcanvas', function() {
            $('#countryForm').attr('action', "{{ route('countries.store') }}");
            $('#countryFormMethod').val('POST');
            $('#country-name').val('');
            $('#offcanvasTitle').text('Add Country');
            $('#countryFormSubmit').text('Submit');
        });
    </script>

@endsection
