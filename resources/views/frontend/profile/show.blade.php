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
        /* make the avatar a bit larger & keep cover behavior */
        .user-profile-img {
            width: 140px !important;
            height: 140px !important;
            object-fit: cover !important;
        }

        /* FilePond preview panel sizing */
        .filepond--root {
            max-width: 360px;
            margin: 0 auto;
        }

        .filepond--panel-root {
            min-height: 140px;
            /* ensures the panel is not tiny */
        }

        /* fine tune image preview inside FilePond */
        .filepond--image-preview-overlay {
            height: 140px !important;
            max-height: 140px !important;
        }

        /* Icon utilities you requested */
        .icon-base {
            display: inline-block;
            vertical-align: middle;
        }

        /* removed invalid selector that caused CSS issues */
        /* . { font-size: 1.5rem; line-height: 1; } */

        /* optional: make brand icons slightly larger */
        .icon-brand {
            font-size: 1.8rem;
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
                                class="h-auto border border-white shadow-sm rounded-circle border-3 user-profile-img">
                        </div>
                        <div class="mt-3 flex-grow-1 mt-lg-5">
                            <div
                                class="gap-4 mx-5 d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start flex-md-row flex-column">
                                <div class="text-center user-profile-info text-md-start">
                                    <h4 class="mb-2 mt-lg-6">
                                        {{-- Example brand icon next to the name (keeps the classes you wanted) --}}
                                        <i class="mb-2 icon-base ti tabler-brand-slack icon-brand me-2"></i>
                                        {{ $user->name }}
                                    </h4>
                                    <ul
                                        class="flex-wrap gap-3 my-2 mb-0 list-inline d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="mb-2 icon-base ti tabler-mail me-1"></i>
                                            <span class="fw-medium">{{ $user->email }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <span
                                                class="badge bg-label-primary">{{ $user->roles->pluck('name')->implode(', ') }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="mb-2 icon-base ti tabler-calendar me-1"></i>
                                            <span class="fw-medium">Joined {{ $user->created_at->format('F Y') }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="mb-2 icon-base ti tabler-circle-dot me-1"></i>
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
                            <i class="mb-2 icon-base ti tabler-user-check me-1"></i> Profile
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#password">
                            <i class="mb-2 icon-base ti tabler-lock me-1"></i> Password
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-danger" data-bs-toggle="tab" href="#delete">
                            <i class="mb-2 icon-base ti tabler-trash me-1"></i> Delete
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
                        <h5 class="mb-4 card-title"><i class="mb-2 icon-base ti tabler-edit me-1"></i> Edit Profile
                        </h5>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf @method('patch')

                            <div class="mb-4 text-center">
                                {{-- FilePond input (accept images only) --}}
                                <input type="file" name="profile_pic" id="profile_pic" accept="image/*" />
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
                                    <i class="mb-2 icon-base ti tabler-device-floppy me-1"></i>
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
                        <h5 class="mb-4 card-title"><i class="mb-2 icon-base ti tabler-lock me-1"></i> Change
                            Password</h5>
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
                                    <i class="mb-2 icon-base ti tabler-refresh me-1"></i>
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
                        <h5 class="mb-4 card-title text-danger"><i class="mb-2 icon-base ti tabler-trash me-1"></i> Delete
                            Account</h5>
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
                                    <i class="mb-2 icon-base ti tabler-alert-triangle me-1"></i>
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
@endsection

@php
    // Make sure $existingProfile is a fully-qualified URL (or null)
    $existingProfile = null;
    if (!empty($user->profile_pic)) {
        $existingProfile = preg_match('/^https?:\/\//', $user->profile_pic)
            ? $user->profile_pic
            : asset('storage/' . $user->profile_pic);
    }
@endphp

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const existingProfile = @json($existingProfile);
            console.log('existingProfile URL:', existingProfile);

            // small debug link under the file input so you can open image in a new tab
            (function addDebugLink() {
                const input = document.querySelector('#profile_pic');
                if (!input) return;
                const dbg = document.createElement('div');
                dbg.style.marginTop = '6px';
                dbg.style.fontSize = '13px';
                if (existingProfile) {
                    dbg.innerHTML =
                        `Current avatar: <a href="${existingProfile}" target="_blank" rel="noopener noreferrer">Open image</a>`;
                } else {
                    dbg.textContent = 'No existing avatar URL detected';
                }
                input.parentNode.appendChild(dbg);
            })();

            // ensure FilePond is loaded, and register plugin(s)
            function waitForFilePondAndInit(retries = 30) {
                if (typeof FilePond === 'undefined') {
                    if (retries <= 0) {
                        console.error('FilePond not found after retries.');
                        return;
                    }
                    // try again shortly
                    setTimeout(() => waitForFilePondAndInit(retries - 1), 100);
                    return;
                }

                // register preview plugin if available
                if (typeof FilePondPluginImagePreview !== 'undefined') {
                    try {
                        FilePond.registerPlugin(FilePondPluginImagePreview);
                    } catch (e) {
                        console.warn('Plugin registration failed (maybe already registered):', e);
                    }
                } else {
                    console.warn('FilePondPluginImagePreview not found — preview plugin not registered.');
                }

                const inputElement = document.querySelector('#profile_pic');
                if (!inputElement) {
                    console.error('FilePond input element (#profile_pic) not found on the page.');
                    return;
                }

                // Create FilePond instance first (clean)
                const pond = FilePond.create(inputElement, {
                    allowImagePreview: true,
                    imagePreviewHeight: 140,
                    stylePanelAspectRatio: 1,
                    labelIdle: `Drag & Drop or <u>Browse</u>`,
                    acceptedFileTypes: ['image/*'],
                    allowReplace: true,
                });

                // If we have a remote URL for the existing avatar, ask FilePond to load it.
                // pond.addFile handles remote URLs and returns a promise.
                if (existingProfile) {
                    // addFile may fail due to CORS if the image server doesn't allow cross-origin requests.
                    pond.addFile(existingProfile).then(
                        (file) => {
                            console.log('Existing profile loaded into FilePond:', file);
                        },
                        (err) => {
                            console.warn(
                                'Failed to load existing profile into FilePond. This may be due to CORS or a network error.',
                                err);
                            // fallback: set a visible label so user can still open image
                            // (debug link added earlier will still work)
                        }
                    );
                }
            }

            waitForFilePondAndInit();
        });
    </script>
@endsection
