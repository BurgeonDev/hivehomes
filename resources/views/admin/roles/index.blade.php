@extends('admin.layouts.app')
@section('title', 'Roles')

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
                <li class="breadcrumb-item active">Roles</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Roles</h5>
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddRole"
                            type="button">
                            <i class="icon-base ti tabler-plus icon-sm"></i> <span class="d-none d-sm-inline-block">Add
                                Role</span>
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
                            <th>Role</th>
                            <th>Permissions</th>
                            <th>Users</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td>
                                    @foreach ($role->permissions as $permission)
                                        <span class="badge bg-label-secondary">{{ $permission->name }}</span>
                                    @endforeach
                                </td>
                                <td>{{ $role->users_count }}</td>
                                <td>
                                    <button class="btn btn-sm badge bg-label-info"
                                        onclick="editRole({{ $role }}, {{ $role->permissions->pluck('name') }})"> <i
                                            class="icon-base ti tabler-edit"></i></button>
                                    @if ($role->name !== 'super-admin')
                                        <form method="POST" action="{{ route('roles.destroy', $role) }}"
                                            class="delete-form d-inline">
                                            @csrf @method('DELETE')
                                            <button class="btn btn-sm badge bg-label-danger show-confirm"> <i
                                                    class="icon-base ti tabler-trash"></i></button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas Add/Edit Role -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddRole">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add Role</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
                    <form method="POST" id="roleForm" action="{{ route('roles.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="roleFormMethod" value="POST">

                        <div class="mb-4">
                            <label class="form-label">Role Name</label>
                            <input type="text" name="name" class="form-control" id="role-name" required>
                        </div>

                        <div class="mb-4">
                            <label class="form-label d-flex justify-content-between">
                                <span>Permissions</span>
                                <a href="javascript:void(0);" onclick="toggleAllPermissions(true)">Select All</a> /
                                <a href="javascript:void(0);" onclick="toggleAllPermissions(false)">Deselect All</a>
                            </label>
                            <div class="row">
                                @foreach ($allPermissions as $permission)
                                    <div class="col-6">
                                        <div class="form-check">
                                            <input class="form-check-input permission-checkbox" type="checkbox"
                                                name="permissions[]" value="{{ $permission->name }}"
                                                id="perm-{{ $permission->id }}">
                                            <label class="form-check-label" for="perm-{{ $permission->id }}">
                                                {{ $permission->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary me-2" id="roleFormSubmit">Submit</button>
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
        function toggleAllPermissions(selectAll) {
            document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = selectAll);
        }

        function editRole(role, permissions) {
            $('#roleForm').attr('action', `/roles/${role.id}`);
            $('#roleFormMethod').val('PUT');
            $('#role-name').val(role.name);
            $('#offcanvasTitle').text('Edit Role');

            $('.permission-checkbox').each(function() {
                this.checked = permissions.includes(this.value);
            });

            const canvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddRole'));
            canvas.show();
        }

        document.getElementById('offcanvasAddRole').addEventListener('hidden.bs.offcanvas', function() {
            $('#roleForm').attr('action', "{{ route('roles.store') }}");
            $('#roleFormMethod').val('POST');
            $('#role-name').val('');
            $('.permission-checkbox').prop('checked', false);
            $('#offcanvasTitle').text('Add Role');
            $('#roleFormSubmit').text('Submit');
        });
    </script>
@endsection
