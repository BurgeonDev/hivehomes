@extends('admin.layouts.app')
@section('title', 'Roles')

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
        <h4 class="mb-1">Roles List</h4>
        <p class="mb-6">
            A role provides access to predefined menus and features. Administrators only see the parts they need.
        </p>

        <div class="row g-6">
            @foreach ($roles as $role)
                <div class="col-xl-4 col-lg-6 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <h6 class="fw-normal mb-0 text-body">Total {{ $role->users->count() }} users</h6>
                                <ul class="list-unstyled d-flex align-items-center avatar-group mb-0">
                                    @foreach ($role->users->take(3) as $user)
                                        <li class="avatar pull-up" data-bs-toggle="tooltip" title="{{ $user->name }}">
                                            <img class="rounded-circle" src="{{ $user->avatar_url }}" alt="Avatar" />
                                        </li>
                                    @endforeach
                                    @if ($role->users->count() > 3)
                                        <li class="avatar">
                                            <span class="avatar-initial rounded-circle pull-up" data-bs-toggle="tooltip"
                                                title="{{ $role->users->count() - 3 }} more">
                                                +{{ $role->users->count() - 3 }}
                                            </span>
                                        </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="d-flex justify-content-between align-items-end">
                                <div class="role-heading">
                                    <h5 class="mb-1">{{ $role->name }}</h5>
                                    <a href="javascript:;" class="role-edit-modal" data-id="{{ $role->id }}"
                                        data-name="{{ $role->name }}"
                                        data-permissions="{{ $role->permissions->pluck('name')->join(',') }}"
                                        data-bs-toggle="modal" data-bs-target="#addRoleModal">
                                        <span>Edit Role</span>
                                    </a>
                                </div>
                                <form action="{{ route('roles.destroy', $role) }}" method="POST"
                                    onsubmit="return confirm('Delete this role?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn p-0"><i
                                            class="icon-base ti tabler-trash icon-md text-heading"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            {{-- Add New Role Card --}}
            <div class="col-xl-4 col-lg-6 col-md-6">
                <div class="card h-100">
                    <div class="row h-100">
                        <div class="col-sm-5 d-flex align-items-center justify-content-center">
                            <img src="{{ asset('assets/img/illustrations/add-new-roles.png') }}" class="img-fluid"
                                alt="Add Role" width="83" />
                        </div>
                        <div class="col-sm-7">
                            <div class="card-body text-sm-end text-center ps-sm-0">
                                <button class="btn btn-sm btn-primary mb-4 add-new-role" data-bs-toggle="modal"
                                    data-bs-target="#addRoleModal">
                                    Add New Role
                                </button>
                                <p class="mb-0">Create a role if it doesn’t exist.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Users with their Roles Table --}}
        <div class="mt-6">
            <h4 class="mb-1">Users &amp; Their Roles</h4>
            <p class="mb-4">Overview of all users and their assigned roles.</p>
            <div class="card">
                <div class="card-datatable">
                    <table class="datatables-users table border-top">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>User</th>
                                <th>Role</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add/Edit Role Modal --}}
    <div class="modal fade" id="addRoleModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    <div class="text-center mb-6">
                        <h4 class="role-title">Role</h4>
                        <p class="text-body-secondary">Define role name &amp; permissions</p>
                    </div>
                    <form id="addRoleForm" method="POST" action="{{ route('roles.store') }}">
                        @csrf
                        <input type="hidden" name="_method" id="roleFormMethod" value="POST">
                        <input type="hidden" name="role_id" id="role_id">
                        <div class="mb-3">
                            <label class="form-label" for="role-name">Role Name</label>
                            <input type="text" id="role-name" name="name" class="form-control" required>
                        </div>
                        <div class="mb-4">
                            <label class="form-label">Permissions</label>
                            <select class="form-select" id="role-permissions" name="permissions[]" multiple required>
                                @foreach ($allPermissions as $perm)
                                    <option value="{{ $perm->name }}">{{ ucfirst($perm->name) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="text-center">
                            <button type="submit" class="btn btn-primary me-3" id="roleSubmit">Submit</button>
                            <button type="button" class="btn btn-label-secondary"
                                data-bs-dismiss="modal">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.js') }}"></script>
@endsection

@section('page-js')
    <script>
        // Handle Add vs Edit
        $('.add-new-role').on('click', () => {
            $('#addRoleForm').trigger('reset');
            $('#addRoleForm').attr('action', "{{ route('roles.store') }}");
            $('#roleFormMethod').val('POST');
            $('#roleSubmit').text('Create');
        });

        $('.role-edit-modal').on('click', function() {
            let id = $(this).data('id'),
                name = $(this).data('name'),
                perms = $(this).data('permissions').split(',');

            $('#addRoleForm').attr('action', `/roles/${id}`);
            $('#roleFormMethod').val('PUT');
            $('#role_id').val(id);
            $('#role-name').val(name);
            $('#role-permissions').val(perms);
            $('#roleSubmit').text('Update');
        });

        // Initialize Datatable for Users
        $('.datatables-users').DataTable({
            processing: true,
            serverSide: true,
            ajax: '{{ route('roles.users.data') }}',
            columns: [{
                    data: 'avatar',
                    name: 'avatar',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'role',
                    name: 'role'
                },
                {
                    data: 'actions',
                    name: 'actions',
                    orderable: false,
                    searchable: false
                },
            ]
        });
    </script>
@endsection
