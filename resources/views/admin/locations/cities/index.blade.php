@extends('admin.layouts.app')
@section('title', 'Cities')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Location</a></li>
                <li class="breadcrumb-item active">Cities</li>
            </ol>
        </nav>

        <div class="card">
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                {{-- Title --}}
                <div class="mt-0 d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto">
                    <h5 class="pb-6 mb-0 text-center card-title text-md-start pb-md-0">Cities</h5>
                </div>

                {{-- Export + Add Button --}}
                <div class="mt-0 d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto">
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
                            data-bs-target="#offcanvasAddCity" aria-controls="offcanvasAddCity" type="button">
                            <span class="gap-2 d-flex align-items-center">
                                <i class="icon-base ti tabler-plus icon-sm"></i>
                                <span class="d-none d-sm-inline-block">Add City</span>
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
                            <th>City</th>
                            <th>State</th>
                            <th>Country</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($cities as $city)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $city->name }}</td>
                                <td>{{ $city->state->name }}</td>
                                <td>{{ $city->state->country->name }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info edit-city-btn"
                                        data-id="{{ $city->id }}" data-name="{{ $city->name }}"
                                        data-state-id="{{ $city->state->id }}"
                                        data-country-id="{{ $city->state->country->id }}" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasAddCity">
                                        <i class="icon-base ti tabler-edit"></i>
                                    </button>
                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST"
                                        class="delete-form d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="show-confirm btn btn-sm badge bg-label-danger">
                                            <i class="icon-base ti tabler-trash"></i>
                                        </button>
                                    </form>
                                </td>


                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Offcanvas --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCity">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add City</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="offcanvas-body">
                    <form method="POST" id="cityForm" action="{{ route('cities.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="form-method" value="POST">
                        <input type="hidden" name="city_id" id="city_id">
                        <div class="mb-3">
                            <label class="form-label">Country</label>
                            <select id="country_id" name="country_id" class="form-select" required>
                                <option value="" selected disabled>Select Country</option>
                                @foreach (\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">State</label>
                            <select id="state_id" name="state_id" class="form-select" required>
                                <option value="" selected disabled>Select State</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">City Name</label>
                            <input type="text" class="form-control" name="name" placeholder="City Name" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
@endsection

@section('page-js')
    <script>
        const countrySelect = $('#country_id');
        const stateSelect = $('#state_id');
        const cityForm = $('#cityForm');
        const formMethodInput = $('#form-method');
        const submitBtn = $('#submit-btn');
        const cityIdInput = $('#city_id');

        // Load states when a country is selected
        countrySelect.on('change', function() {
            const countryId = $(this).val();

            if (!countryId) return;

            fetch(`/get-states-by-country/${countryId}`)
                .then(res => res.json())
                .then(data => {
                    let options = `<option value="" disabled selected>Select State</option>`;
                    data.forEach(state => {
                        options += `<option value="${state.id}">${state.name}</option>`;
                    });
                    stateSelect.html(options);
                })
                .catch(error => console.error('Error loading states:', error));
        });

        // Edit button clicked
        $('.edit-city-btn').on('click', function() {
            const cityId = $(this).data('id');
            const cityName = $(this).data('name');
            const stateId = $(this).data('state-id');
            const countryId = $(this).data('country-id');

            // Set form to update mode
            cityForm.attr('action', `/cities/${cityId}`);
            formMethodInput.val('PUT');
            cityIdInput.val(cityId);
            submitBtn.text('Update');

            // Set values
            $('input[name="name"]').val(cityName);
            countrySelect.val(countryId).trigger('change');

            // Wait for states to load before setting the selected state
            setTimeout(() => {
                stateSelect.val(stateId);
            }, 500);
        });

        // Reset form when opening the add city form
        $('#offcanvasAddCity').on('hidden.bs.offcanvas', function() {
            cityForm.trigger('reset');
            cityForm.attr('action', '{{ route('cities.store') }}');
            formMethodInput.val('POST');
            cityIdInput.val('');
            submitBtn.text('Save');
            stateSelect.html('<option value="" selected disabled>Select State</option>');
        });
    </script>

@endsection
