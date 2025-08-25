@extends('admin.layouts.app')
@section('title', 'Societies')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                <li class="breadcrumb-item active">Societies</li>
            </ol>
        </nav>

        <div class="card">
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                {{-- Title --}}
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Societies</h5>
                </div>

                {{-- Export + Add Buttons --}}
                <div class="col-md-auto ms-auto">
                    <div class="flex-wrap mb-0 dt-buttons btn-group">
                        {{-- Export Dropdown --}}
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

                        {{-- Add Button --}}
                        <button class="btn create-new btn-primary" data-bs-toggle="offcanvas"
                            data-bs-target="#offcanvasAddSociety" aria-controls="offcanvasAddSociety" type="button">
                            <span class="gap-2 d-flex align-items-center">
                                <i class="icon-base ti tabler-plus icon-sm"></i>
                                <span class="d-none d-sm-inline-block">Add Society</span>
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
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Admin</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($societies as $society)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $society->name }}</td>
                                <td>{{ $society->address }}</td>
                                <td>{{ $society->city->name ?? '-' }}</td>
                                <td>{{ $society->state->name ?? '-' }}</td>
                                <td>{{ $society->country->name ?? '-' }}</td>
                                <td>{{ $society->admin->name ?? '-' }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info"
                                        onclick='editSociety(@json($society))'> <i
                                            class="icon-base ti tabler-edit"></i></button>
                                    <form method="POST" action="{{ route('societies.destroy', $society->id) }}"
                                        class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm badge bg-label-danger show-confirm"> <i
                                                class="icon-base ti tabler-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Offcanvas Add/Edit -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddSociety">
        <div class="offcanvas-header border-bottom">
            <h5 class="offcanvas-title" id="offcanvasAddSocietyLabel">Add Society</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="flex-grow-0 p-4 mx-0 offcanvas-body h-100">
            <form method="POST" action="{{ route('societies.store') }}" id="societyForm">
                @csrf
                <input type="hidden" name="_method" id="societyFormMethod" value="POST">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control" name="name" id="society-name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Address</label>
                    <input type="text" class="form-control" name="address" id="society-address">
                </div>

                <div class="mb-3">
                    <label class="form-label">Country</label>
                    <select class="form-select" name="country_id" id="society-country">
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">State</label>
                    <select class="form-select" name="state_id" id="society-state">
                        <option value="">Select State</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">City</label>
                    <select class="form-select" name="city_id" id="society-city">
                        <option value="">Select City</option>
                    </select>
                </div>


                <div class="mb-3">
                    <label class="form-label">Admin (optional)</label>
                    <select class="form-select" name="admin_user_id" id="society-admin">
                        <option value="">-- No Admin --</option>
                        @foreach ($admins as $admin)
                            <option value="{{ $admin->id }}">{{ $admin->name }}</option>
                        @endforeach
                    </select>
                </div>


                <button type="submit" class="btn btn-primary">Submit</button>
                <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
            </form>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
@endsection

@section('page-js')
    <script>
        // Load States on Country Change
        $('#society-country').on('change', function() {
            const countryId = $(this).val();
            $('#society-state').html('<option value="">Loading...</option>');
            $('#society-city').html('<option value="">Select City</option>');

            if (countryId) {
                $.get(`/get-states-by-country/${countryId}`, function(data) {
                    let options = '<option value="">Select State</option>';
                    data.forEach(function(state) {
                        options += `<option value="${state.id}">${state.name}</option>`;
                    });
                    $('#society-state').html(options);
                });
            } else {
                $('#society-state').html('<option value="">Select State</option>');
            }
        });

        // Load Cities on State Change
        $('#society-state').on('change', function() {
            const stateId = $(this).val();
            $('#society-city').html('<option value="">Loading...</option>');

            if (stateId) {
                $.get(`/get-cities-by-state/${stateId}`, function(data) {
                    let options = '<option value="">Select City</option>';
                    data.forEach(function(city) {
                        options += `<option value="${city.id}">${city.name}</option>`;
                    });
                    $('#society-city').html(options);
                });
            } else {
                $('#society-city').html('<option value="">Select City</option>');
            }
        });

        // Optional: Refill state/city when editing
        function loadStates(countryId, selectedStateId = null) {
            if (!countryId) return;
            $.get(`/get-states-by-country/${countryId}`, function(data) {
                let options = '<option value="">Select State</option>';
                data.forEach(function(state) {
                    options +=
                        `<option value="${state.id}" ${selectedStateId == state.id ? 'selected' : ''}>${state.name}</option>`;
                });
                $('#society-state').html(options);
            });
        }

        function loadCities(stateId, selectedCityId = null) {
            if (!stateId) return;
            $.get(`/get-cities-by-state/${stateId}`, function(data) {
                let options = '<option value="">Select City</option>';
                data.forEach(function(city) {
                    options +=
                        `<option value="${city.id}" ${selectedCityId == city.id ? 'selected' : ''}>${city.name}</option>`;
                });
                $('#society-city').html(options);
            });
        }

        function editSociety(society) {
            $('#societyForm').attr('action', `/societies/${society.id}`);
            $('#societyFormMethod').val('PUT');
            $('#society-name').val(society.name);
            $('#society-address').val(society.address);
            $('#society-country').val(society.country_id);
            loadStates(society.country_id, society.state_id);
            loadCities(society.state_id, society.city_id);
            $('#society-admin').val(society.admin_user_id ? society.admin_user_id : '');
            $('#offcanvasAddSocietyLabel').text('Edit Society');
            new bootstrap.Offcanvas(document.getElementById('offcanvasAddSociety')).show();
        }
    </script>

@endsection
