@extends('auth.layouts.app')
@section('title', 'Register')

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="py-6 authentication-inner">
                <div class="card">
                    <div class="card-body">
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

                        <h4 class="mb-1">Adventure starts here 🚀</h4>
                        <p class="mb-6">Register to get started. Your account will be approved by admin.</p>

                        <form method="POST" action="{{ route('register') }}" class="mb-6">
                            @csrf

                            <!-- Name -->
                            <div class="mb-6">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror"
                                    id="name" name="name" value="{{ old('name') }}" placeholder="Enter your name"
                                    required autofocus />
                                @error('name')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email"
                                    required />
                                @error('email')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div class="mb-6">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                    id="phone" name="phone" value="{{ old('phone') }}"
                                    placeholder="Enter your phone number" />
                                @error('phone')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-6 form-password-toggle">
                                <label class="form-label" for="password">Password</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="********" required autocomplete="new-password" />
                                    <span class="cursor-pointer input-group-text"><i
                                            class="icon-base ti tabler-eye-off"></i></span>
                                </div>
                                @error('password')
                                    <div class="mt-1 text-danger">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-6">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" id="password_confirmation" class="form-control"
                                    name="password_confirmation" placeholder="********" required
                                    autocomplete="new-password" />
                            </div>

                            <!-- Country > State > City > Society dropdowns -->
                            <div class="mb-6 row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Country</label>
                                    <select class="form-select" id="country" name="country_id">
                                        <option value="">Select Country</option>
                                        @foreach ($countries as $country)
                                            <option value="{{ $country->id }}">{{ $country->name }}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">State</label>
                                    <select class="form-select" name="state_id" id="state">
                                        <option value="">Select State</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">City</label>
                                    <select class="form-select" name="city_id" id="city">
                                        <option value="">Select City</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Society</label>
                                    <select class="form-select @error('society_id') is-invalid @enderror"
                                        name="society_id" id="society">
                                        <option value="">Select Society</option>
                                    </select>
                                    @error('society_id')
                                        <div class="mt-1 text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>


                            <!-- Terms -->
                            <div class="my-8">
                                <div class="mb-0 form-check ms-2">
                                    <input class="form-check-input" type="checkbox" id="terms-conditions" name="terms"
                                        required>
                                    <label class="form-check-label" for="terms-conditions">
                                        I agree to <a href="javascript:void(0);">privacy policy & terms</a>
                                    </label>
                                </div>
                            </div>

                            <!-- Submit -->
                            <button type="submit" class="btn btn-primary d-grid w-100">Sign Up</button>
                        </form>

                        <p class="text-center">
                            <span>Already have an account?</span>
                            <a href="{{ route('login') }}">
                                <span>Sign in instead</span>
                            </a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')

    <script>
        $(document).ready(function() {
            // States
            $('#country').on('change', function() {
                let countryId = $(this).val();
                $('#state').html('<option value="">Loading...</option>');
                $('#city').html('<option value="">Select City</option>');
                $('#society').html('<option value="">Select Society</option>');

                if (countryId) {
                    $.get('/get-states-by-country/' + countryId, function(data) {
                        let options = '<option value="">Select State</option>';
                        data.forEach(state => {
                            options += `<option value="${state.id}">${state.name}</option>`;
                        });
                        $('#state').html(options);
                    });
                }
            });

            // Cities
            $('#state').on('change', function() {
                let stateId = $(this).val();
                $('#city').html('<option value="">Loading...</option>');
                $('#society').html('<option value="">Select Society</option>');

                if (stateId) {
                    $.get('/get-cities-by-state/' + stateId, function(data) {
                        let options = '<option value="">Select City</option>';
                        data.forEach(city => {
                            options += `<option value="${city.id}">${city.name}</option>`;
                        });
                        $('#city').html(options);
                    });
                }
            });

            // Societies
            $('#city').on('change', function() {
                let cityId = $(this).val();
                $('#society').html('<option value="">Loading...</option>');

                if (cityId) {
                    $.get('/get-societies-by-city/' + cityId, function(data) {
                        let options = '<option value="">Select Society</option>';
                        data.forEach(society => {
                            options +=
                                `<option value="${society.id}">${society.name}</option>`;
                        });
                        $('#society').html(options);
                    });
                }
            });
        });
    </script>


@endsection
