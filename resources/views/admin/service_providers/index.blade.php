@extends('admin.layouts.app')
@section('title', 'Service Providers')

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
                <li class="breadcrumb-item active">Service Providers</li>
            </ol>
        </nav>

        <div class="card">
            {{-- Header --}}
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Service Providers</h5>
                </div>
                <div class="col-md-auto ms-auto">
                    <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasSPForm">
                        <i class="icon-base ti tabler-plus icon-sm"></i>
                        <span class="d-none d-sm-inline-block">Add Provider</span>
                    </button>
                </div>
            </div>

            {{-- Table --}}
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Phone</th>
                            <th>Email</th>
                            @role('super_admin')
                                <th>Society</th>
                            @endrole
                            <th>Approved</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($providers as $sp)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td class="d-flex align-items-center">
                                    @if ($sp->profile_image_url)
                                        <img src="{{ asset('storage/' . $sp->profile_image_url) }}"
                                            class="rounded-circle me-2" width="32" height="32">
                                    @else
                                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sp->name) }}&background=ddd&color=555"
                                            class="rounded-circle me-2" width="32" height="32">
                                    @endif
                                    {{ $sp->name }}
                                </td>
                                <td>{{ ucfirst($sp->type) }}</td>
                                <td>{{ $sp->phone }}</td>
                                <td>{{ $sp->email }}</td>
                                @role('super_admin')
                                    <td>{{ $sp->society->name }}</td>
                                @endrole
                                <td>
                                    @if ($sp->is_approved)
                                        <span class="badge bg-success">Yes</span>
                                    @else
                                        <span class="badge bg-warning">No</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info" onclick='editSP(@json($sp))'>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.service-providers.destroy', $sp) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this provider?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Offcanvas Add/Edit --}}
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasSPForm">
                <div class="offcanvas-header border-bottom">
                    <h5 id="spCanvasTitle" class="offcanvas-title">Add Provider</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="p-4 offcanvas-body">
                    <form id="spForm" action="{{ route('admin.service-providers.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="spFormMethod" value="POST">

                        @if (auth()->user()->hasRole('super_admin'))
                            <div class="mb-3">
                                <label class="form-label">Society</label>
                                <select name="society_id" id="sp-society" class="form-select" required>
                                    <option value="">Select society…</option>
                                    @foreach ($allSocieties as $society)
                                        <option value="{{ $society->id }}">{{ $society->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="society_id" value="{{ auth()->user()->society_id }}">
                        @endif

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" id="sp-name" class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Type</label>
                            <select name="type" id="sp-type" class="form-select" required>
                                <option value="">Select type…</option>
                                <option value="plumber">Plumber</option>
                                <option value="electrician">Electrician</option>
                                <option value="carpenter">Carpenter</option>
                            </select>
                        </div>

                        <div class="mb-3 row">
                            <div class="col">
                                <label class="form-label">Phone</label>
                                <input type="text" name="phone" id="sp-phone" class="form-control">
                            </div>
                            <div class="col">
                                <label class="form-label">Email</label>
                                <input type="email" name="email" id="sp-email" class="form-control">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">CNIC</label>
                            <input type="number" name="cnic" id="sp-cnic" class="form-control">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Address</label>
                            <textarea name="address" id="sp-address" class="form-control" rows="2"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Bio / Services</label>
                            <textarea name="bio" id="sp-bio" class="form-control" rows="3"></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Profile Image</label>
                            <div class="mb-2">
                                <img src="https://ui-avatars.com/api/?name=&background=ddd&color=555" id="sp-preview-img"
                                    class="rounded-circle" width="60" height="60">
                            </div>
                            <input type="file" name="profile_image" id="sp-profile-image" class="form-control">
                        </div>

                        <div class="mb-4 form-check">
                            <input class="form-check-input" type="checkbox" name="is_approved" id="sp-approved">
                            <label class="form-check-label" for="sp-approved">Approved</label>
                        </div>

                        <button type="submit" class="btn btn-primary me-2" id="spFormSubmit">Submit</button>
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
        function editSP(sp) {
            // form setup
            $('#spForm').attr('action', `/admin/service-providers/${sp.id}`);
            $('#spFormMethod').val('PUT');
            $('#spCanvasTitle').text('Edit Provider');
            $('#spFormSubmit').text('Update');

            // fill values
            @if (auth()->user()->hasRole('super_admin'))
                $('#sp-society').val(sp.society_id);
            @endif
            $('#sp-name').val(sp.name);
            $('#sp-type').val(sp.type);
            $('#sp-phone').val(sp.phone);
            $('#sp-email').val(sp.email);
            $('#sp-cnic').val(sp.cnic);
            $('#sp-address').val(sp.address);
            $('#sp-bio').val(sp.bio);
            $('#sp-approved').prop('checked', sp.is_approved);

            // preview image or avatar
            if (sp.profile_image_url) {
                $('#sp-preview-img').attr('src', `/storage/${sp.profile_image_url}`);
            } else {
                $('#sp-preview-img').attr('src',
                    `https://ui-avatars.com/api/?name=${encodeURIComponent(sp.name)}&background=ddd&color=555`);
            }

            new bootstrap.Offcanvas($('#offcanvasSPForm')).show();
        }

        // live preview on file select
        $('#sp-profile-image').on('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = e => $('#sp-preview-img').attr('src', e.target.result);
                reader.readAsDataURL(file);
            }
        });

        // reset form on close
        document.getElementById('offcanvasSPForm').addEventListener('hidden.bs.offcanvas', function() {
            $('#spForm').attr('action', "{{ route('admin.service-providers.store') }}");
            $('#spFormMethod').val('POST');
            $('#spCanvasTitle').text('Add Provider');
            $('#spFormSubmit').text('Submit');
            $('#spForm')[0].reset();
            $('#sp-preview-img').attr('src', 'https://ui-avatars.com/api/?name=&background=ddd&color=555');
        });
    </script>
@endsection
