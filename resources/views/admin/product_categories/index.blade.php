@extends('admin.layouts.app')
@section('title', 'Product Categories')

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
                <li class="breadcrumb-item active">Product Categories</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Product Categories</h5>
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCategory"
                            type="button" id="btnAddCategory">
                            <i class="icon-base ti tabler-plus icon-sm"></i>
                            <span class="d-none d-sm-inline-block">Add Category</span>
                        </button>
                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic ">
                    <thead>
                        <tr>
                            <th style="width:60px">#</th>
                            <th>Name</th>
                            {{-- <th>Slug</th> --}}
                            <th>Description</th>
                            <th style="width:160px" class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($categories as $cat)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $cat->name }}</td>
                                {{-- <td>{{ $cat->slug }}</td> --}}
                                <td class="text-truncate" style="max-width:420px;">
                                    {{ \Illuminate\Support\Str::limit($cat->description, 120) }}
                                </td>
                                <td class="text-end">
                                    <button class="btn btn-sm badge bg-label-info btn-edit-category"
                                        data-cat='@json($cat)'> <i
                                            class="icon-base ti tabler-edit"></i></button>

                                    <form method="POST" action="{{ route('admin.product-categories.destroy', $cat) }}"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button class="show-confirm btn btn-sm badge bg-label-danger"> <i
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

    <!-- Offcanvas Add/Edit Category -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasCategory">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasTitle" class="offcanvas-title">Add Category</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>

        <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
            <form method="POST" id="categoryForm" action="{{ route('admin.product-categories.store') }}">
                @csrf
                <input type="hidden" name="_method" id="categoryFormMethod" value="POST">

                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" id="cat-name" required>
                </div>

                <!-- Slug removed (auto-generated in backend) -->

                <div class="mb-3">
                    <label class="form-label">Description (optional)</label>
                    <textarea name="description" class="form-control" id="cat-description" rows="4"></textarea>
                </div>

                <div class="gap-2 d-flex">
                    <button type="submit" class="btn btn-primary" id="categoryFormSubmit">Submit</button>
                    <button type="reset" class="btn btn-label-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
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
        document.addEventListener('DOMContentLoaded', function() {
            // Edit button (delegate to handle DataTables redraw)
            $(document).on('click', '.btn-edit-category', function() {
                let cat = $(this).data('cat');

                const form = document.getElementById('categoryForm');
                form.setAttribute('action', `/admin/product-categories/${cat.id}`);
                document.getElementById('categoryFormMethod').value = 'PUT';

                document.getElementById('cat-name').value = cat.name ?? '';
                document.getElementById('cat-description').value = cat.description ?? '';

                document.getElementById('offcanvasTitle').innerText = 'Edit Category';
                document.getElementById('categoryFormSubmit').innerText = 'Save';

                let canvas = bootstrap.Offcanvas.getOrCreateInstance(
                    document.getElementById('offcanvasCategory')
                );
                canvas.show();
            });

            // Reset form on close
            document.getElementById('offcanvasCategory')
                .addEventListener('hidden.bs.offcanvas', function() {
                    const form = document.getElementById('categoryForm');
                    form.setAttribute('action', "{{ route('admin.product-categories.store') }}");
                    document.getElementById('categoryFormMethod').value = 'POST';
                    document.getElementById('cat-name').value = '';
                    document.getElementById('cat-description').value = '';
                    document.getElementById('offcanvasTitle').innerText = 'Add Category';
                    document.getElementById('categoryFormSubmit').innerText = 'Submit';
                });
        });
    </script>
@endsection
