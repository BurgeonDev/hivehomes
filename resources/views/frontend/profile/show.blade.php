@extends('frontend.layouts.app')
@section('title', 'My Profile')

@section('vendor-css')
    {{-- FilePond CSS --}}
    <link href="https://unpkg.com/filepond/dist/filepond.min.css" rel="stylesheet" />
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.css"
        rel="stylesheet" />
@endsection

@section('page-css')
    <style>
        /* avatar */
        .user-profile-img {
            width: 140px !important;
            height: 140px !important;
            object-fit: cover !important;
        }



        /* ensure preview fills the panel and keeps cover */


        .fp-debug {
            margin-top: 6px;
            font-size: 13px;
            color: #6c757d;
        }

        .fp-error {
            margin-top: 6px;
            font-size: 0.85rem;
            color: #d63384;
        }
    </style>
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        @php
            $user = auth()->user();
            $avatarUrl = $user->profile_pic
                ? asset('storage/' . $user->profile_pic)
                : 'https://ui-avatars.com/api/?name=' . urlencode($user->name) . '&background=random&bold=true';

            // existingProfile: full URL or null (used by FilePond preload)
            $existingProfile = null;
            if (!empty($user->profile_pic)) {
                $existingProfile = preg_match('/^https?:\/\//', $user->profile_pic)
                    ? $user->profile_pic
                    : asset('storage/' . $user->profile_pic);
            }
        @endphp

        {{-- Profile Header --}}
        <div class="row">
            <div class="col-12">
                <div class="mb-6 border-0 shadow-sm card">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image"
                            class="rounded-top w-100" style="height: 200px; object-fit: cover;">
                    </div>

                    <div class="mb-5 text-center user-profile-header d-flex flex-column flex-lg-row text-sm-start">
                        <div class="flex-shrink-0 mx-auto mt-n4 mx-sm-0">
                            <img src="{{ $avatarUrl }}" alt="user image"
                                class="h-auto border border-white shadow-sm rounded-circle border-3 user-profile-img"
                                style="width:120px; height:120px; object-fit:cover;">
                        </div>
                        <div class="mt-3 flex-grow-1 mt-lg-5">
                            <div
                                class="gap-4 mx-5 d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start flex-md-row flex-column">
                                <div class="text-center user-profile-info text-md-start">
                                    <h4 class="mb-2 mt-lg-6">{{ $user->name }}</h4>
                                    <ul
                                        class="flex-wrap gap-3 my-2 mb-0 list-inline d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-mail me-1"></i>
                                            <span class="fw-medium">{{ $user->email }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-users me-1"></i>
                                            <span
                                                class="badge bg-label-primary">{{ $user->roles->pluck('name')->implode(', ') }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-calendar me-1"></i>
                                            <span class="fw-medium">Joined {{ $user->created_at->format('F Y') }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-circle-dot me-1"></i>
                                            <span
                                                class="badge {{ $user->status === 'active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                                {{ ucfirst($user->status) }}
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Nav Tabs --}}
        <div class="mb-4 row">
            <div class="col-md-12">
                <ul class="gap-2 nav nav-pills flex-column flex-sm-row gap-sm-0 justify-content-center">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#profile">
                            <i class="icon-base ti tabler-user-check me-1"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#password">
                            <i class="icon-base ti tabler-lock me-1"></i> Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-bs-toggle="tab" href="#delete">
                            <i class="icon-base ti tabler-trash me-1"></i> Delete
                        </a>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
            {{-- Edit Profile --}}
            <div class="tab-pane fade show active" id="profile">
                <div class="border-0 shadow-sm card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title"><i class="icon-base ti tabler-edit me-1"></i> Edit Profile</h5>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf @method('patch')

                            <div class="mb-4 text-center">
                                <div style="max-width: 420px; margin: 0 auto;">
                                    <!-- FilePond input -->
                                    <input type="file" name="profile_pic" id="profile_pic" accept="image/*" />
                                </div>
                                @error('profile_pic')
                                    <div class="mt-1 text-danger small">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="row gx-3">
                                {{-- Name --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name"
                                        class="form-control @error('name') is-invalid @enderror"
                                        value="{{ old('name', $user->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', $user->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', $user->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Society --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Society</label>
                                    <input type="text" class="form-control" value="{{ $user->society->name ?? 'N/A' }}"
                                        disabled>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="icon-base ti tabler-device-floppy me-1"></i>
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="tab-pane fade" id="password">
                <div class="border-0 shadow-sm card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title"><i class="icon-base ti tabler-lock me-1"></i> Change Password</h5>
                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf @method('put')
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Confirm New</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">
                                    <i class="icon-base ti tabler-refresh me-1"></i>
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="tab-pane fade" id="delete">
                <div class="border shadow-sm card border-danger">
                    <div class="card-body">
                        <h5 class="mb-4 card-title text-danger">
                            <i class="icon-base ti tabler-trash me-1"></i>
                            Delete Account
                        </h5>
                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf @method('delete')
                            <p class="mb-3 text-muted">Permanently delete your account and all associated data.</p>
                            <div class="mb-3">
                                <label class="form-label">Confirm Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="text-end">
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">
                                    <i class="icon-base ti tabler-alert-triangle me-1"></i>
                                    Delete Account
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('vendor-js')
    {{-- FilePond JS --}}
    <script src="https://unpkg.com/filepond/dist/filepond.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.min.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.min.js">
    </script>
@endsection

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Register plugins
            try {
                FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
            } catch (e) {
                console.warn('FilePond plugin registration:', e);
            }

            const inputElement = document.querySelector('#profile_pic');
            if (!inputElement) {
                console.error('#profile_pic not found');
                return;
            }

            // create instance; storeAsFile:true makes the file available on normal form submit
            const pond = FilePond.create(inputElement, {
                allowImagePreview: true,
                labelIdle: `<span class="filepond--label-action">Drag & Drop or <u>Browse</u></span>`,
                acceptedFileTypes: ['image/*'],
                storeAsFile: true,
                credits: false,
                allowReplace: true,
            });

            // Preload existing profile image (if present)
            const existingProfile = @json($existingProfile);
            if (existingProfile) {
                pond.addFile(existingProfile).then(
                    file => console.log('Preloaded avatar into FilePond', file),
                    err => console.warn('Could not preload avatar (CORS or network):', err)
                );
            }
        });
    </script>
@endsection
