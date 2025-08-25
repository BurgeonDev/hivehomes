@extends('admin.layouts.app')
@section('title', 'Service Provider Types')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Service Provider Types</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Service Provider Types</h5>
                </div>
                <div class="col-md-auto ms-auto">
                    <div class="flex-wrap mb-0 dt-buttons btn-group">
                        <div class="btn-group">
                            <button class="btn btn-label-primary dropdown-toggle me-4" type="button" id="exportDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasTypeForm"
                            type="button">
                            <i class="icon-base ti tabler-plus icon-sm"></i> <span class="d-none d-sm-inline-block">Add
                                Type</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Type Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($types as $type)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info" onclick="editType({{ $type }})">
                                        <i class="icon-base ti tabler-edit"></i></button>

                                    <form method="POST" action="{{ route('admin.types.destroy', $type) }}"
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

            <!-- Offcanvas Add/Edit Type -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasTypeForm">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add Type</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
                    <form method="POST" id="typeForm" action="{{ route('admin.types.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="typeFormMethod" value="POST">

                        <div class="mb-4">
                            <label class="form-label">Type Name</label>
                            <input type="text" name="name" class="form-control" id="type-name" required>
                        </div>

                        <button type="submit" class="btn btn-primary me-2" id="typeFormSubmit">Submit</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>
                </div>
            </div>
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
        function editType(type) {
            $('#typeForm').attr('action', `/admin/types/${type.id}`);
            $('#typeFormMethod').val('PUT');
            $('#type-name').val(type.name);
            $('#offcanvasTitle').text('Edit Type');

            const canvas = new bootstrap.Offcanvas(document.getElementById('offcanvasTypeForm'));
            canvas.show();
        }

        document.getElementById('offcanvasTypeForm').addEventListener('hidden.bs.offcanvas', function() {
            $('#typeForm').attr('action', "{{ route('admin.types.store') }}");
            $('#typeFormMethod').val('POST');
            $('#type-name').val('');
            $('#offcanvasTitle').text('Add Type');
        });
    </script>
@endsection
