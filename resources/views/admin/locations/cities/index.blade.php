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
            <div class="row card-header mx-0 px-3">
                <div class="col d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Cities</h5>
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddCity">
                        <i class="icon-base ti tabler-plus icon-sm me-1"></i> Add City
                    </button>
                </div>
            </div>

            <div class="card-datatable table-responsive p-3">
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
                                        Edit
                                    </button>

                                    <form action="{{ route('cities.destroy', $city->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Are you sure you want to delete this city?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm badge bg-label-danger">Delete</button>
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
