@extends('frontend.layouts.app')
@section('title', 'Terms & Conditions ')

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
                    <li class="breadcrumb-item active text-dark" aria-current="page">Terms and Conditions</li>
                </ol>
            </nav>
        </div>
    </section>
    <section id="landingTerms" class="section-py bg-body landing-terms">
        <div class="container">
            <div class="mb-4 text-center">
                <span class="badge bg-label-primary">Terms & Conditions</span>
            </div>
            <h4 class="mb-1 text-center">
                Our
                <span class="position-relative fw-extrabold z-1">Terms
                    <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="terms icon"
                        class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                </span>
            </h4>
            <p class="mb-12 text-center pb-md-4">
                Please read these terms carefully before using our services. By continuing, you agree to the conditions
                below.
            </p>
            <div class="row gy-12 align-items-center">

                <div class="col-lg-12">
                    <div class="accordion" id="termsAccordion">

                        <!-- Term 1 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="termOne">
                                <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTermOne" aria-expanded="true" aria-controls="collapseTermOne">
                                    <i class="icon-base ti tabler-shield-check me-2"></i>
                                    Acceptance of Terms
                                </button>
                            </h2>
                            <div id="collapseTermOne" class="accordion-collapse collapse show"
                                data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    By accessing or using our services, you agree to be bound by these terms and all
                                    applicable laws.
                                </div>
                            </div>
                        </div>

                        <!-- Term 2 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="termTwo">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTermTwo" aria-expanded="false" aria-controls="collapseTermTwo">
                                    <i class="icon-base ti tabler-credit-card me-2"></i>
                                    Payments & Billing
                                </button>
                            </h2>
                            <div id="collapseTermTwo" class="accordion-collapse collapse" data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    All payments must be made in accordance with the pricing plan selected. Late or failed
                                    payments may suspend your access.
                                </div>
                            </div>
                        </div>

                        <!-- Term 3 -->
                        <div class="card accordion-item">
                            <h2 class="accordion-header" id="termThree">
                                <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                    data-bs-target="#collapseTermThree" aria-expanded="false"
                                    aria-controls="collapseTermThree">
                                    <i class="icon-base ti tabler-alert-triangle me-2"></i>
                                    Limitations of Liability
                                </button>
                            </h2>
                            <div id="collapseTermThree" class="accordion-collapse collapse"
                                data-bs-parent="#termsAccordion">
                                <div class="accordion-body">
                                    We are not responsible for indirect, incidental, or consequential damages arising from
                                    the use of our services.
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>


@endsection
