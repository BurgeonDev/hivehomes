@extends('auth.layouts.app')
@section('title', 'Reset Password')


@section('content')

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="py-6 authentication-inner">
                <!-- Reset Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="mb-6 app-brand justify-content-center">
                            <a href="{{ route('login') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        <!-- Your SVG logo here -->
                                    </span>
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">HiveHomes</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1">Reset Password 🔒</h4>
                        <p class="mb-6">
                            <span class="fw-medium">Your new password must be different from previously used
                                passwords</span>
                        </p>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Hidden Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror" name="email"
                                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                                    placeholder="Enter your email" />
                                @error('email')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="new-password" placeholder="••••••••••••" />
                                    <span class="cursor-pointer input-group-text">
                                        <i class="icon-base ti tabler-eye-off"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6 form-password-toggle form-control-validation">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password_confirmation" class="form-control"
                                        name="password_confirmation" required autocomplete="new-password"
                                        placeholder="••••••••••••" />
                                    <span class="cursor-pointer input-group-text">
                                        <i class="icon-base ti tabler-eye-off"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <button class="mb-6 btn btn-primary d-grid w-100">
                                Set New Password
                            </button>

                            <!-- Back to login -->
                            <div class="text-center">
                                <a href="{{ route('login') }}" class="d-flex justify-content-center">
                                    <i class="icon-base ti tabler-chevron-left scaleX-n1-rtl me-1_5"></i>
                                    Back to login
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- /Reset Password -->
            </div>
        </div>
    </div>


@endsection
