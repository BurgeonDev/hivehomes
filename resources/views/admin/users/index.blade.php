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
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Users</h5>
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
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddUser"
                            type="button">
                            <i class="icon-base ti tabler-plus icon-sm"></i>
                            <span class="d-none d-sm-inline-block">Add User</span>
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
                            <th>Photo</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Society</th>
                            <th>Roles</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($user->profile_pic)
                                        <img src="{{ asset('storage/' . $user->profile_pic) }}" class="rounded-circle"
                                            style="width:40px;height:40px;object-fit:cover;">
                                    @else
                                        <span class="text-muted">—</span>
                                    @endif
                                </td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ $user->phone ?? '—' }}</td>
                                <td>{{ $user->society->name ?? '—' }}</td>
                                <td>
                                    @foreach ($user->roles as $role)
                                        <span class="badge bg-label-secondary">{{ $role->name }}</span>
                                    @endforeach
                                </td>
                                <td>
                                    <span class="badge {{ $user->status === 'active' ? 'bg-success' : 'bg-danger' }}">
                                        {{ ucfirst($user->status) }}
                                    </span>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info"
                                        onclick="editUser({{ $user }}, '{{ $user->roles->first()->name ?? '' }}')">
                                        Edit
                                    </button>
                                    <form method="POST" action="{{ route('users.destroy', $user) }}" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete?')">Delete</button>
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
        <div class="flex-grow-0 p-4 mx-0 offcanvas-body h-100">
            <form method="POST" action="{{ route('users.store') }}" id="userForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="userFormMethod" value="POST">
                <input type="hidden" id="user-id" name="user_id">

                <div class="mb-3">
                    <label class="form-label" for="user-name">Full Name</label>
                    <input type="text" class="form-control" id="user-name" name="name" required>
                </div>

                <div class="mb-3">
                    <label class="form-label" for="user-email">Email</label>
                    <input type="email" class="form-control" id="user-email" name="email" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="user-phone">Phone</label>
                    <input type="text" class="form-control" id="user-phone" name="phone">
                </div>

                <div class="mb-3">
                    <label class="form-label" for="user-status">Status</label>
                    <select name="status" id="user-status" class="form-select">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Profile Picture</label>
                    <input type="file" name="profile_pic" class="form-control">
                    <div id="current-pic-wrapper" class="mt-2" style="display:none;">
                        <img src="" id="current-pic" class="rounded-circle"
                            style="width:60px;height:60px;object-fit:cover;">
                    </div>
                </div>
                @role('super_admin')
                    <div class="mb-3">
                        <label class="form-label" for="user-society">Society</label>
                        <select name="society_id" id="user-society" class="form-select" required>
                            <option value="">— Select Society —</option>
                            @foreach ($societies as $society)
                                <option value="{{ $society->id }}">{{ $society->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    {{-- Society Admin / Member: hidden, auto-assigned --}}
                    <input type="hidden" name="society_id" value="{{ auth()->user()->society_id }}">
                @endrole
                @role('super_admin')
                    <div class="mb-3">
                        <label class="form-label" for="user-role">Role</label>
                        <select class="form-select" id="user-role" name="role" required>
                            <option value="">— Select Role —</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                @else
                    <input type="hidden" name="role" value="member">
                @endrole


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
        const userStoreUrl = "{{ route('users.store') }}";
        const userUpdateUrl = "{{ url('users') }}/";

        function editUser(user, role) {
            $('#userForm').attr('action', userUpdateUrl + user.id);
            $('#userFormMethod').val('PUT');
            $('#user-id').val(user.id);
            $('#user-name').val(user.name);
            $('#user-email').val(user.email);
            $('#user-phone').val(user.phone);
            $('#user-status').val(user.status);
            $('#user-role').val(role);
            $('#user-password').removeAttr('required').closest('#passwordField').hide();

            if (user.profile_pic) {
                $('#current-pic-wrapper').show();
                $('#current-pic').attr('src', `/storage/${user.profile_pic}`);
            } else {
                $('#current-pic-wrapper').hide();
            }

            $('#offcanvasAddUserLabel').text('Edit User');
            new bootstrap.Offcanvas($('#offcanvasAddUser')).show();
        }

        $('#offcanvasAddUser').on('hidden.bs.offcanvas', function() {
            $('#userForm').attr('action', userStoreUrl);
            $('#userFormMethod').val('POST');
            $('#user-id,#user-name,#user-email,#user-phone').val('');
            $('#user-status,#user-role').val('');
            $('#user-password').val('').attr('required', true).closest('#passwordField').show();
            $('#current-pic-wrapper').hide();
            $('#offcanvasAddUserLabel').text('Add User');
        });
    </script>


@endsection
