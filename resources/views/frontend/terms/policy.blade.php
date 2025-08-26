@extends('frontend.layouts.app')
@section('title', 'Policies ')

@section('content')

    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 300px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">

        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Policies</li>
                </ol>
            </nav>
        </div>
    </section>
    <section id="landingPolicy" class="section-py bg-body landing-policy">
        <div class="container">
            <div class="mb-4 text-center">
                <span class="badge bg-label-primary">Policies</span>
            </div>
            <h4 class="mb-1 text-center">
                Our
                <span class="position-relative fw-extrabold z-1">Policies
                    <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="policy icon"
                        class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                </span>
            </h4>
            <p class="mb-12 text-center pb-md-4">
                Learn about how we handle privacy, refunds, and data protection to ensure transparency and trust.
            </p>
            <div class="row gy-12 align-items-center">

                <div class="col-lg-12">
                    <div class="accordion" id="policyAccordion">

                        <!-- Policy 1 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="policyOne">
                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePolicyOne" aria-expanded="true"
                                    aria-controls="collapsePolicyOne">
                                    <i class="icon-base ti tabler-lock me-2"></i>
                                    Privacy Policy
                                </button>
                            </h2>
                            <div id="collapsePolicyOne" class="accordion-collapse collapse show"
                                data-bs-parent="#policyAccordion">
                                <div class="accordion-body">
                                    We collect and process your data responsibly, using secure methods. Your information
                                    will never be shared without consent.
                                </div>
                            </div>
                        </div>

                        <!-- Policy 2 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="policyTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePolicyTwo" aria-expanded="false"
                                    aria-controls="collapsePolicyTwo">
                                    <i class="icon-base ti tabler-rotate-clockwise me-2"></i>
                                    Refund Policy
                                </button>
                            </h2>
                            <div id="collapsePolicyTwo" class="accordion-collapse collapse"
                                data-bs-parent="#policyAccordion">
                                <div class="accordion-body">
                                    Refunds are available under certain conditions. Please review our refund guidelines
                                    before requesting one.
                                </div>
                            </div>
                        </div>

                        <!-- Policy 3 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="policyThree">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapsePolicyThree" aria-expanded="false"
                                    aria-controls="collapsePolicyThree">
                                    <i class="icon-base ti tabler-shield-lock me-2"></i>
                                    Data Protection
                                </button>
                            </h2>
                            <div id="collapsePolicyThree" class="accordion-collapse collapse"
                                data-bs-parent="#policyAccordion">
                                <div class="accordion-body">
                                    Your data is encrypted and access is restricted to authorized staff only, ensuring
                                    maximum security.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
