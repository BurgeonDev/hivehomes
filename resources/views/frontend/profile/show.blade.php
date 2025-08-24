@extends('frontend.layouts.app')
@section('title', 'My Profile')

@section('vendor-css')
    <!-- any vendor CSS you need -->
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Profile Header --}}
        <div class="row">
            <div class="col-12">
                <div class="mb-6 card">
                    <div class="user-profile-header-banner">
                        <img src="{{ asset('assets/img/pages/profile-banner.png') }}" alt="Banner image"
                            class="rounded-top w-100" style="height: 200px; object-fit: cover;">
                    </div>

                    <div class="mb-5 text-center user-profile-header d-flex flex-column flex-lg-row text-sm-start">
                        <div class="flex-shrink-0 mx-auto mt-n2 mx-sm-0">
                            @php
                                $user = auth()->user();
                                $avatarUrl = $user->profile_pic
                                    ? asset('storage/' . $user->profile_pic)
                                    : 'https://ui-avatars.com/api/?name=' .
                                        urlencode($user->name) .
                                        '&background=random&bold=true';
                            @endphp
                            <img src="{{ $avatarUrl }}" alt="user image"
                                class="h-auto rounded d-block ms-0 ms-sm-6 user-profile-img"
                                style="width:120px; height:120px; object-fit:cover;">
                        </div>
                        <div class="mt-3 flex-grow-1 mt-lg-5">
                            <div
                                class="gap-4 mx-5 d-flex align-items-md-end align-items-sm-start align-items-center justify-content-md-between justify-content-start flex-md-row flex-column">
                                <div class="user-profile-info">
                                    <h4 class="mb-2 mt-lg-6">{{ $user->name }}</h4>
                                    <ul
                                        class="flex-wrap gap-4 my-2 mb-0 list-inline d-flex align-items-center justify-content-sm-start justify-content-center">
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-mail icon-lg"></i>
                                            <span class="fw-medium">{{ $user->email }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-users icon-lg"></i>
                                            <span class="fw-medium">{{ $user->roles->pluck('name')->implode(', ') }}</span>
                                        </li>
                                        <li class="gap-2 list-inline-item d-flex align-items-center">
                                            <i class="icon-base ti tabler-calendar icon-lg"></i>
                                            <span class="fw-medium">Joined {{ $user->created_at->format('F Y') }}</span>
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
                <div class="nav-align-top">
                    <ul class="gap-2 mb-6 nav nav-pills flex-column flex-sm-row gap-sm-0">
                        <li class="nav-item">
                            <a class="nav-link active waves-effect waves-light" href="#profile" data-bs-toggle="tab">
                                <i class="icon-base ti tabler-user-check icon-sm me-1_5"></i> Profile
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="#password" data-bs-toggle="tab">
                                <i class="icon-base ti tabler-lock icon-sm me-1_5"></i> Password
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link waves-effect waves-light" href="#delete" data-bs-toggle="tab">
                                <i class="icon-base ti tabler-trash icon-sm me-1_5"></i> Delete
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        {{-- Tab Content --}}
        <div class="tab-content">
            {{-- Edit Profile --}}
            <div class="tab-pane fade show active" id="profile">
                <div class="mb-4 card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Edit Profile</h5>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf @method('patch')

                            <div class="mb-4 text-center">
                                <img src="{{ $avatarUrl }}" class="mb-3 rounded-circle"
                                    style="width:100px;height:100px;object-fit:cover;">
                                <div>
                                    <label class="btn btn-sm btn-outline-secondary">
                                        Change Photo
                                        <input type="file" name="profile_pic" hidden>
                                    </label>
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

                                {{-- Status --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <select class="form-select" disabled>
                                        <option value="active" {{ $user->status === 'active' ? 'selected' : '' }}>Active
                                        </option>
                                        <option value="inactive" {{ $user->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    <input type="hidden" name="status" value="{{ $user->status }}">
                                </div>

                                {{-- Society --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Society</label>
                                    <input type="text" class="form-control" value="{{ $user->society->name ?? 'N/A' }}"
                                        disabled>
                                </div>

                                {{-- Roles --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control"
                                        value="{{ $user->roles->pluck('name')->implode(', ') }}" disabled>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Change Password --}}
            <div class="tab-pane fade" id="password">
                <div class="mb-4 card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Change Password</h5>
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
                                <button type="submit" class="btn btn-warning">Update Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Delete Account --}}
            <div class="tab-pane fade" id="delete">
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="mb-4 card-title text-danger">Delete Account</h5>
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
                                <button class="btn btn-danger" onclick="return confirm('Are you sure?')">Delete
                                    Account</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('vendor-js')
    <!-- any vendor JS you need -->
@endsection

@section('page-js')
    <!-- any page-specific JS you need -->
@endsection
