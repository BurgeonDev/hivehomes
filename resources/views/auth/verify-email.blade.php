@extends('auth.layouts.app')
@section('title', 'Reset Password')


@section('content')

    <div class="container px-4 mx-auto mt-10">
        <div class="p-6 bg-white rounded shadow dark:bg-gray-800">
            <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
            </p>

            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600 dark:text-green-400">
                    {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                </div>
            @endif

            <div class="flex items-center justify-between mt-4">
                <form method="POST" action="{{ route('verification.send') }}">
                    @csrf
                    <button type="submit"
                        class="px-4 py-2 font-semibold text-white bg-indigo-600 rounded hover:bg-indigo-700">
                        {{ __('Resend Verification Email') }}
                    </button>
                </form>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-sm text-gray-600 underline dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
