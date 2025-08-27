@extends('admin.layouts.app')
@section('title', 'Post Categories')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Post Categories</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Post Categories</h5>
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddCategory"
                            type="button">
                            <i class="icon-base ti tabler-plus icon-sm"></i>
                            <span class="d-none d-sm-inline-block">Add Category</span>
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
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $category->name }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info"
                                        onclick="editCategory({{ $category }})">
                                        <i class="icon-base ti tabler-edit"></i>
                                    </button>

                                    <form method="POST" action="{{ route('admin.post-categories.destroy', $category) }}"
                                        class="delete-form d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm badge bg-label-danger show-confirm">
                                            <i class="icon-base ti tabler-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas Add/Edit Category -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddCategory">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add Category</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
                    <form method="POST" id="categoryForm" action="{{ route('admin.post-categories.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="categoryFormMethod" value="POST">

                        <div class="mb-4">
                            <label class="form-label">Category Name</label>
                            <input type="text" name="name" class="form-control" id="category-name" required>
                        </div>

                        <button type="submit" class="btn btn-primary me-2" id="categoryFormSubmit">Submit</button>
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
        function editCategory(category) {
            $('#categoryForm').attr('action', `/admin/post-categories/${category.id}`);
            $('#categoryFormMethod').val('PUT');
            $('#category-name').val(category.name);
            $('#offcanvasTitle').text('Edit Category');
            $('#categoryFormSubmit').text('Update');

            const canvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddCategory'));
            canvas.show();
        }

        document.getElementById('offcanvasAddCategory').addEventListener('hidden.bs.offcanvas', function() {
            $('#categoryForm').attr('action', "{{ route('admin.post-categories.store') }}");
            $('#categoryFormMethod').val('POST');
            $('#category-name').val('');
            $('#offcanvasTitle').text('Add Category');
            $('#categoryFormSubmit').text('Submit');
        });
    </script>
@endsection
