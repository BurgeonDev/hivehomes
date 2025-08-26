@extends('auth.layouts.app')
@section('title', 'Login')
@section('vendor-css')

@endsection
@section('page-css')
@endsection

@section('content')

    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="py-6 authentication-inner">
                <!-- Login -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="mb-6 app-brand justify-content-center">
                            <a href="{{ url('/') }}" class="app-brand-link">
                                <span class="app-brand-logo demo">
                                    <span class="text-primary">
                                        <!-- SVG logo -->
                                        <svg width="32" height="22" viewBox="0 0 32 22" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M0.00172773 0V6.85398C0.00172773 6.85398 -0.133178 9.01207 1.98092 10.8388L13.6912 21.9964L19.7809 21.9181L18.8042 9.88248L16.4951 7.17289L9.23799 0H0.00172773Z"
                                                fill="currentColor" />
                                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.69824 16.4364L12.5199 3.23696L16.5541 7.25596L7.69824 16.4364Z"
                                                fill="#161616" />
                                            <path opacity="0.06" fill-rule="evenodd" clip-rule="evenodd"
                                                d="M8.07751 15.9175L13.9419 4.63989L16.5849 7.28475L8.07751 15.9175Z"
                                                fill="#161616" />
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M7.77295 16.3566L23.6563 0H32V6.88383C32 6.88383 31.8262 9.17836 30.6591 10.4057L19.7824 22H13.6938L7.77295 16.3566Z"
                                                fill="currentColor" />
                                        </svg>
                                    </span>
                                </span>
                                <span class="app-brand-text demo text-heading fw-bold">HiveHomes</span>
                            </a>
                        </div>
                        <!-- /Logo -->

                        <h4 class="mb-1">Welcome to HiveHomes! 👋</h4>
                        <p class="mb-6">Please sign-in to your account and start the adventure</p>

                        <!-- Laravel Form -->
                        <form method="POST" action="{{ route('login') }}" class="mb-4">
                            @csrf

                            <!-- Session Status -->
                            @if (session('status'))
                                <div class="mb-4 text-success">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="form-label">Email or Phone</label>
                                <input type="text" id="email" name="email"
                                    class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}"
                                    required autofocus placeholder="Enter your email or phone no" />
                                @error('email')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required placeholder="••••••••••••" />
                                    <span class="cursor-pointer input-group-text"><i
                                            class="icon-base ti tabler-eye-off"></i></span>
                                </div>
                                @error('password')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Remember Me + Forgot Password -->
                            <div class="my-8">
                                <div class="d-flex justify-content-between">
                                    <div class="mb-0 form-check ms-2">
                                        <input class="form-check-input" type="checkbox" id="remember_me" name="remember" />
                                        <label class="form-check-label" for="remember_me"> Remember Me </label>
                                    </div>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}">
                                            <p class="mb-0">Forgot Password?</p>
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <!-- Submit -->
                            <div class="mb-6">
                                <button class="btn btn-primary d-grid w-100" type="submit">Login</button>
                            </div>
                        </form>

                        <!-- Register -->
                        <p class="text-center">
                            <span>New on our platform?</span>
                            <a href="{{ route('register') }}">
                                <span>Create an account</span>
                            </a>
                        </p>
                    </div>
                </div>
                <!-- /Login -->
            </div>
        </div>
    </div>


@endsection
@section('vendor-js')

@endsection
@section('page-js')
@endsection
