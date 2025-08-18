@extends('auth.layouts.app')
@section('title', 'Reset Password')
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/form-validation.css') }}" />
@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endsection

@section('content')

    <div class="container mx-auto mt-10 px-4">
        <div class="bg-white dark:bg-gray-800 rounded shadow p-6">
            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 font-medium text-sm text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="mt-4 flex items-center justify-between">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="bg-indigo-600 hover:bg-indigo-700 text-white font-semibold py-2 px-4 rounded">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="underline text-sm text-gray-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>




@endsection
@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/@form-validation/popular.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/bootstrap5.j') }}s"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/auto-focus.js') }}"></script>
@endsection
@section('page-js')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection
