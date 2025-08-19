@extends('admin.layouts.app')
@section('title', 'My Profile')

@section('vendor-css')
    <!-- any vendor CSS you need -->
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">My Profile</li>
            </ol>
        </nav>

        <div class="row gy-4">

            {{-- 1) Edit Profile Details --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Edit Profile</h5>

                        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data">
                            @csrf @method('patch')

                            {{-- Avatar --}}
                            <div class="mb-4 text-center">
                                <img src="{{ auth()->user()->profile_pic
                                    ? asset('storage/' . auth()->user()->profile_pic)
                                    : asset('assets/img/avatars/default.png') }}"
                                    class="mb-3 rounded-circle" style="width:100px;height:100px;object-fit:cover;">
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
                                        value="{{ old('name', auth()->user()->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Email --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email"
                                        class="form-control @error('email') is-invalid @enderror"
                                        value="{{ old('email', auth()->user()->email) }}" required>
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone</label>
                                    <input type="text" name="phone"
                                        class="form-control @error('phone') is-invalid @enderror"
                                        value="{{ old('phone', auth()->user()->phone) }}">
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Status</label>
                                    <select name="status" class="form-select @error('status') is-invalid @enderror"
                                        required>
                                        <option value="active" {{ auth()->user()->status === 'active' ? 'selected' : '' }}>
                                            Active</option>
                                        <option value="inactive" {{ auth()->user()->status === 'inactive' ? 'selected' : '' }}>
                                            Inactive</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Society (read‐only) --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Society</label>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->society->name ?? 'N/A' }}" disabled>
                                </div>

                                {{-- Roles (read‐only) --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Role</label>
                                    <input type="text" class="form-control"
                                        value="{{ auth()->user()->roles->pluck('name')->implode(', ') }}" disabled>
                                </div>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">
                                    Save Changes
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            {{-- 2) Change Password --}}
            <div class="col-12 col-md-6">
                <div class="card">
                    <div class="card-body">
                        <h5 class="mb-4 card-title">Change Password</h5>

                        <form method="POST" action="{{ route('password.update') }}">
                            @csrf @method('put')

                            {{-- Current --}}
                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <input type="password" name="current_password"
                                    class="form-control @error('current_password') is-invalid @enderror" required>
                                @error('current_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- New --}}
                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <input type="password" name="password"
                                    class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm --}}
                            <div class="mb-3">
                                <label class="form-label">Confirm New</label>
                                <input type="password" name="password_confirmation" class="form-control" required>
                            </div>

                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">
                                    Update Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>


            {{-- 3) Delete Account --}}
            <div class="col-12 col-md-6">
                <div class="card border-danger">
                    <div class="card-body">
                        <h5 class="mb-4 card-title text-danger">Delete Account</h5>

                        <form method="POST" action="{{ route('profile.destroy') }}">
                            @csrf @method('delete')

                            <p class="mb-3 text-muted">
                                Permanently delete your account and all associated data.
                            </p>

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
    <!-- any vendor JS you need -->
@endsection

@section('page-js')
    <!-- any page-specific JS you need -->
@endsection
