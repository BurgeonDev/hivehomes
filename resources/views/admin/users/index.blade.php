@extends('admin.layouts.app')
@section('title', 'Users')

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
                <li class="breadcrumb-item active">Users</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="row card-header flex-column flex-md-row border-bottom mx-0 px-3">
                <div class="col-md-auto me-auto">
                    <h5 class="card-title mb-0">Users</h5>
                </div>
                <div class="col-md-auto ms-auto">
                    <div class="dt-buttons btn-group flex-wrap mb-0">
                        <div class="btn-group">
                            <button class="btn btn-label-primary dropdown-toggle me-4" type="button" id="exportDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"
                            type="button">
                            <i class="icon-base ti tabler-plus icon-sm"></i>
                            <span class="d-none d-sm-inline-block">Add User</span>
                        </button>

                    </div>
                </div>
            </div>

            <!-- DataTable -->
            <div class="card-datatable table-responsive p-3">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-label-secondary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info"
                                        onclick="editUser({{ $user }}, '{{ $user->roles->first()->name ?? '' }}')">Edit</button>

                                    <form method="POST" action="{{ route('users.destroy', $user->id) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this user?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
    <!-- Offcanvas Add/Edit User -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddUser" aria-labelledby="offcanvasAddUserLabel">
        <div class="offcanvas-header border-bottom">
            <h5 id="offcanvasAddUserLabel" class="offcanvas-title">Add User</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body mx-0 flex-grow-0 p-4 h-100">
            <form method="POST" action="{{ route('users.store') }}" id="userForm">
                @csrf
                <input type="hidden" name="_method" id="userFormMethod" value="POST">
                <input type="hidden" id="user-id" name="user_id" value="">

                <div class="mb-3">
                    <label class="form-label" for="user-name">Full Name</label>
                    <input type="text" class="form-control" id="user-name" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="user-email">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="user-role">Role</label>
                    <select class="form-select" id="user-role" name="role">
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3" id="passwordField">
                    <label class="form-label" for="user-password">Password</label>
                    <input type="password" class="form-control" id="user-password" name="password" required>
                </div>

                <button type="submit" class="btn btn-primary me-2" id="userFormSubmit">Submit</button>
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
        function editUser(user, role) {
            $('#userForm').attr('action', `/users/${user.id}`);
            $('#userFormMethod').val('PUT');
            $('#user-id').val(user.id);
            $('#user-name').val(user.name);
            $('#user-email').val(user.email);
            $('#user-role').val(role);
            $('#user-password').removeAttr('required').closest('#passwordField').hide();

            $('#offcanvasAddUserLabel').text('Edit User');
            const canvas = new bootstrap.Offcanvas(document.getElementById('offcanvasAddUser'));
            canvas.show();
        }

        document.getElementById('offcanvasAddUser').addEventListener('hidden.bs.offcanvas', function() {
            $('#userForm').attr('action', "{{ route('users.store') }}");
            $('#userFormMethod').val('POST');
            $('#user-id').val('');
            $('#user-name').val('');
            $('#user-email').val('');
            $('#user-role').val('');
            $('#user-password').val('').attr('required', true).closest('#passwordField').show();
            $('#offcanvasAddUserLabel').text('Add User');
            $('#userFormSubmit').text('Submit');
        });
    </script>

@endsection
