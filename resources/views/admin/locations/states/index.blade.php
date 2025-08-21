@extends('admin.layouts.app')
@section('title', 'States')
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
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript:void(0);">Location</a></li>
                <li class="breadcrumb-item active">States</li>
            </ol>
        </nav>

        <div class="card">
            {{-- Header --}}
            <div class="row card-header flex-column flex-md-row border-bottom mx-0 px-3">
                <div class="d-md-flex justify-content-between align-items-center dt-layout-start col-md-auto me-auto mt-0">
                    <h5 class="card-title mb-0 text-md-start text-center pb-md-0 pb-6">States</h5>
                </div>
                <div class="d-md-flex justify-content-between align-items-center dt-layout-end col-md-auto ms-auto mt-0">
                    <div class="dt-buttons btn-group flex-wrap mb-0">
                        <div class="btn-group">
                            <button class="btn buttons-collection btn-label-primary dropdown-toggle me-4" type="button"
                                id="exportDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <span class="d-flex align-items-center gap-2">
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
                            data-bs-target="#offcanvasAddState" aria-controls="offcanvasAddState" type="button">
                            <span class="d-flex align-items-center gap-2">
                                <i class="icon-base ti tabler-plus icon-sm"></i>
                                <span class="d-none d-sm-inline-block">Add State</span>
                            </span>
                        </button>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="card-datatable table-responsive p-3">
                <table class="datatables-basic table">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>State Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($states as $state)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $state->name }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info"
                                        onclick="editState({{ $state }})">Edit</button>
                                    <form method="POST" action="{{ route('states.destroy', $state) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm badge bg-label-danger"
                                            onclick="return confirm('Delete this state?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Offcanvas --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddState"
                aria-labelledby="offcanvasAddStateLabel">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add State</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <div class="offcanvas-body mx-0 flex-grow-0 p-6 h-100">
                    <form method="POST" id="stateForm">
                        @csrf
                        <input type="hidden" name="_method" id="stateFormMethod" value="POST">
                        <div class="mb-6">
                            <label class="form-label" for="state-name">State Name</label>
                            <input type="text" name="name" class="form-control" id="state-name" placeholder="Punjab"
                                required>
                        </div>
                        <div class="mb-6">
                            <label class="form-label" for="country-id">Country <span class="text-danger">*</span></label>
                            <select name="country_id" id="country-id" class="form-select" required>
                                <option value="" disabled selected>Select Country</option>
                                @foreach (\App\Models\Country::all() as $country)
                                    <option value="{{ $country->id }}">{{ $country->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary me-3" id="stateFormSubmit">Submit</button>
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
    <script>
        function editState(state) {
            $('#stateForm').attr('action', '/states/' + state.id);
            $('#stateFormMethod').val('PUT');
            $('#state-name').val(state.name);
            $('#country-id').val(state.country_id); // Set country
            $('#offcanvasTitle').text('Edit State');
            $('#stateFormSubmit').text('Update');
            const offcanvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddState'));
            offcanvas.show();
        }


        document.getElementById('offcanvasAddState').addEventListener('hidden.bs.offcanvas', function() {
            $('#stateForm').attr('action', "{{ route('states.store') }}");
            $('#stateFormMethod').val('POST');
            $('#state-name').val('');
            $('#country-id').val(''); // Reset country
            $('#offcanvasTitle').text('Add State');
            $('#stateFormSubmit').text('Submit');
        });
    </script>
@endsection
