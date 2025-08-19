@extends('frontend.layouts.app')
@section('title', 'Lead Pipeline')
@section('vendor-css')

@endsection
@section('page-css')
@endsection

@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        <section id="hero-animation">
            <div id="landingHero" class="section-py landing-hero position-relative bg-light">
                <div class="container">
                    <div class="text-center hero-text-box position-relative">
                        <h1 class="text-primary hero-title display-5 fw-extrabold">
                            HiveHomes
                        </h1>
                        <h3 class="mb-3 text-dark fw-bold">
                            Simplify Life in Your Society
                        </h3>
                        <p class="mb-4 text-secondary lead">
                            A modern platform for connected communities — enabling smooth communication,
                            local commerce, and effortless access to trusted services.
                        </p>
                        <a href="#registerSociety" class="px-5 btn btn-primary btn-lg">
                            Join Your Society Now
                        </a>
                    </div>

                    <!-- Features: Start -->
                    <div class="mt-5 text-center row g-4">
                        <div class="col-md-4">
                            <div class="bg-transparent border-0 shadow-sm card h-100">
                                <div class="card-body">
                                    <div class="mb-3 text-primary">
                                        <i class="mb-2 icon-base ti tabler-brand-slack icon-xl"></i>
                                    </div>
                                    <h5 class="fw-bold">Community Updates</h5>
                                    <p class="text-muted">
                                        Stay in the loop with notices, events, emergencies, and announcements — all in one
                                        place.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-transparent border-0 shadow-sm card h-100">
                                <div class="card-body">
                                    <div class="mb-3 text-success">
                                        <i class="icon-base ti tabler-shopping-cart fs-1 icon-xl"></i>
                                    </div>
                                    <h5 class="fw-bold">Buy & Sell Locally</h5>
                                    <p class="text-muted">
                                        Discover a built-in marketplace for members to sell used items or find great local
                                        deals.
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="bg-transparent border-0 shadow-sm card h-100">
                                <div class="card-body">
                                    <div class="mb-3 text-warning">
                                        <i class="icon-base ti tabler-users fs-1 icon-xl"></i>
                                    </div>
                                    <h5 class="fw-bold">Find Trusted Help</h5>
                                    <p class="text-muted">
                                        Need a plumber, electrician, or tutor? Access a list of verified professionals from
                                        your area.
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Features: End -->

                </div>
            </div>

        </section>
        <!-- Hero: End -->




        <!-- HiveHomes Features: Start -->
        <section id="hiveFeatures" class="section-py landing-features">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Community Tools</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Your Digital Society Hub
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="hive icon"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                    Stay connected, organized, and empowered.
                </h4>
                <p class="mb-12 text-center">
                    HiveHomes brings everything you need to manage and engage your society—all in one place.
                </p>
                <div class="features-icon-wrapper row gx-0 gy-6 g-sm-12">
                    <!-- Member Networking -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="mb-2 icon-base ti tabler-users icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Member Connection</h5>
                        <p class="features-icon-description">
                            Connect with society members, share updates, and build stronger community relationships.
                        </p>
                    </div>

                    <!-- Buy/Sell Products -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="icon-base ti tabler-shopping-cart fs-1 icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Buy & Sell in Your Society</h5>
                        <p class="features-icon-description">
                            Post and explore products for sale or purchase from trusted neighbors.
                        </p>
                    </div>

                    <!-- Professionals Listing -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="icon-base ti tabler-tools fs-1 icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Find Local Professionals</h5>
                        <p class="features-icon-description">
                            Quickly hire electricians, plumbers, cleaners, and more within your community.
                        </p>
                    </div>

                    <!-- Notice Board -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="icon-base ti tabler-bell fs-1 icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Notice Board</h5>
                        <p class="features-icon-description">
                            View announcements, event details, and community rules from admins or management.
                        </p>
                    </div>

                    <!-- Polls & Feedback -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="icon-base ti tabler-message-dots fs-1 icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Community Polls</h5>
                        <p class="features-icon-description">
                            Vote on society decisions and give feedback to help improve your neighborhood.
                        </p>
                    </div>

                    <!-- Secure Payments -->
                    <div class="text-center col-lg-4 col-sm-6 features-icon-box">
                        <div class="mb-4 text-center text-primary">
                            <i class="icon-base ti tabler-credit-card fs-1 icon-xl"></i>
                        </div>
                        <h5 class="mb-2">Bill & Dues Management</h5>
                        <p class="features-icon-description">
                            Pay society dues, maintenance bills, and track your payment history securely.
                        </p>
                    </div>
                </div>
            </div>
        </section>
        <!-- HiveHomes Features: End -->


        <!-- Real customers reviews: Start -->
        <section id="landingReviews" class="pb-0 section-py bg-body landing-reviews">
            <!-- What people say slider: Start -->
            <div class="container">
                <div class="mb-5 row align-items-center gx-0 gy-4 g-lg-5 pb-md-5">
                    <div class="col-md-6 col-lg-5 col-xl-3">
                        <div class="mb-4">
                            <span class="badge bg-label-primary">Real Customers Reviews</span>
                        </div>
                        <h4 class="mb-1">
                            <span class="position-relative fw-extrabold z-1">What people say
                                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                                    alt="laptop charging"
                                    class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                            </span>
                        </h4>
                        <p class="mb-5 mb-md-12">
                            See what our customers have to<br class="d-none d-xl-block" />
                            say about their experience.
                        </p>
                        <div class="landing-reviews-btns">
                            <button id="reviews-previous-btn" class="btn btn-icon btn-label-primary reviews-btn me-3"
                                type="button">
                                <i class="icon-base ti tabler-chevron-left icon-md scaleX-n1-rtl"></i>
                            </button>
                            <button id="reviews-next-btn" class="btn btn-icon btn-label-primary reviews-btn" type="button">
                                <i class="icon-base ti tabler-chevron-right icon-md scaleX-n1-rtl"></i>
                            </button>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-7 col-xl-9">
                        <div class="overflow-hidden swiper-reviews-carousel">
                            <div class="swiper" id="swiper-reviews">
                                <div class="swiper-wrapper">
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-1.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “HivesHomes is hands down the most useful front end Bootstrap theme
                                                    I've
                                                    ever used. I can't wait
                                                    to use it again for my next project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Cecilia Payne</h6>
                                                        <p class="mb-0 small text-body-secondary">CEO of Airbnb</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-2.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “I've never used a theme as versatile and flexible as HivesHomes.
                                                    It's
                                                    my
                                                    go to for building
                                                    dashboard sites on almost any project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/2.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Eugenia Moore</h6>
                                                        <p class="mb-0 small text-body-secondary">Founder of Hubspot
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-3.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    This template is really clean & well documented. The docs are really
                                                    easy to understand and
                                                    it's always easy to find a screenshot from their website.
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/3.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Curtis Fletcher</h6>
                                                        <p class="mb-0 small text-body-secondary">Design Lead at
                                                            Dribbble</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-4.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    All the requirements for developers have been taken into
                                                    consideration, so I’m able to build
                                                    any interface I want.
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/4.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Sara Smith</h6>
                                                        <p class="mb-0 small text-body-secondary">Founder of
                                                            Continental</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-5.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    “I've never used a theme as versatile and flexible as HivesHomes.
                                                    It's
                                                    my
                                                    go to for building
                                                    dashboard sites on almost any project.”
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/5.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Eugenia Moore</h6>
                                                        <p class="mb-0 small text-body-secondary">Founder of Hubspot
                                                        </p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="swiper-slide">
                                        <div class="card h-100">
                                            <div
                                                class="card-body text-body d-flex flex-column justify-content-between h-100">
                                                <div class="mb-4">
                                                    <img src="{{ asset('assets/img/front-pages/branding/logo-6.png') }}"
                                                        alt="client logo" class="client-logo img-fluid" />
                                                </div>
                                                <p>
                                                    Lorem ipsum dolor sit amet consectetur adipisicing elit. Veniam nemo
                                                    mollitia, ad eum
                                                    officia numquam nostrum repellendus consequuntur!
                                                </p>
                                                <div class="mb-4 text-warning">
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                    <i class="icon-base ti tabler-star-filled"></i>
                                                </div>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar me-3 avatar-sm">
                                                        <img src="{{ asset('assets/img/avatars/1.png') }}" alt="Avatar"
                                                            class="rounded-circle" />
                                                    </div>
                                                    <div>
                                                        <h6 class="mb-0">Sara Smith</h6>
                                                        <p class="mb-0 small text-body-secondary">Founder of
                                                            Continental</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- What people say slider: End -->
            <hr class="m-0 mt-6 mt-md-12" />
            <!-- Logo slider: Start -->
            <div class="container">
                <div class="pt-8 swiper-logo-carousel">
                    <div class="swiper" id="swiper-clients-logos">
                        <div class="swiper-wrapper">
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_1-light.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_1-light.png"
                                    data-app-dark-img="front-pages/branding/logo_1-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_2-light.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_2-light.png"
                                    data-app-dark-img="front-pages/branding/logo_2-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_3-light.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_3-light.png"
                                    data-app-dark-img="front-pages/branding/logo_3-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_4-light.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_4-light.png"
                                    data-app-dark-img="front-pages/branding/logo_4-dark.png" />
                            </div>
                            <div class="swiper-slide">
                                <img src="{{ asset('assets/img/front-pages/branding/logo_5-light.png') }}"
                                    alt="client logo" class="client-logo"
                                    data-app-light-img="front-pages/branding/logo_5-light.png"
                                    data-app-dark-img="front-pages/branding/logo_5-dark.png" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Logo slider: End -->
        </section>
        <!-- Real customers reviews: End -->

        <!-- Our great team: Start -->
        <section id="landingTeam" class="section-py landing-team">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Our Great Team</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Supported
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                    by Real People
                </h4>
                <p class="pb-0 text-center mb-md-11 pb-xl-12">Who is behind these great-looking interfaces?</p>
                <div class="mt-2 row gy-12">
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-primary border-bottom-0 border-label-primary position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-1.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50" alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-primary">
                                <h5 class="mb-0 card-title">Sophie Gilbert</h5>
                                <p class="mb-0 text-body-secondary">Project Manager</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-info border-bottom-0 border-label-info position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-2.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50" alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-info">
                                <h5 class="mb-0 card-title">Paul Miles</h5>
                                <p class="mb-0 text-body-secondary">UI Designer</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-danger border-bottom-0 border-label-danger position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-3.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50" alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-danger">
                                <h5 class="mb-0 card-title">Nannie Ford</h5>
                                <p class="mb-0 text-body-secondary">Development Lead</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6">
                        <div class="mt-3 shadow-none card mt-lg-0">
                            <div
                                class="border bg-label-success border-bottom-0 border-label-success position-relative team-image-box">
                                <img src="{{ asset('assets/img/front-pages/landing-page/team-member-4.png') }}"
                                    class="bottom-0 position-absolute card-img-position start-50" alt="human image" />
                            </div>
                            <div class="text-center border card-body border-top-0 border-label-success">
                                <h5 class="mb-0 card-title">Chris Watkins</h5>
                                <p class="mb-0 text-body-secondary">Marketing Manager</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Our great team: End -->

        <!-- Pricing plans: Start -->
        <section id="landingPricing" class="section-py bg-body landing-pricing">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Pricing Plans</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Tailored pricing plans
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                    designed for you
                </h4>
                <p class="pb-2 text-center mb-7">
                    All plans include 40+ advanced tools and features to boost your product.<br />Choose the best plan
                    to fit
                    your needs.
                </p>
                <div class="mb-12 text-center">
                    <div class="pt-3 position-relative d-inline-block pt-md-0">
                        <label class="switch switch-sm switch-primary me-0">
                            <span class="switch-label fs-6 text-body me-3">Pay Monthly</span>
                            <input type="checkbox" class="switch-input price-duration-toggler" checked />
                            <span class="switch-toggle-slider">
                                <span class="switch-on"></span>
                                <span class="switch-off"></span>
                            </span>
                            <span class="switch-label fs-6 text-body ms-3">Pay Annual</span>
                        </label>
                        <div class="pricing-plans-item position-absolute d-flex">
                            <img src="{{ asset('assets/img/front-pages/icons/pricing-plans-arrow.png') }}"
                                alt="pricing plans arrow" class="scaleX-n1-rtl" />
                            <span class="mt-2 fw-medium ms-1"> Save 25%</span>
                        </div>
                    </div>
                </div>
                <div class="row g-6 pt-lg-5">
                    <!-- Basic Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/paper-airplane.png') }}"
                                        alt="paper airplane icon" class="pb-2 mb-8" />
                                    <h4 class="mb-0">Basic</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$19</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$14</span>
                                        <sub class="h6 text-body-secondary mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-body-secondary price-yearly-toggle d-none">$ 168
                                            / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Timeline
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Basic search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Live chat widget
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Email marketing
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Custom Forms
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Traffic analytics
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Basic Support
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="payment-page.html" class="btn btn-label-primary">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Basic Plan: End -->

                    <!-- Favourite Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="border shadow-xl card border-primary">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/plane.png') }}" alt="plane icon"
                                        class="pb-2 mb-8" />
                                    <h4 class="mb-0">Team</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$29</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$22</span>
                                        <sub class="h6 text-body-secondary mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-body-secondary price-yearly-toggle d-none">$ 264
                                            / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Everything in basic
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Timeline with database
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Advanced search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Marketing automation
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Advanced chatbot
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Campaign management
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Collaboration tools
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="payment-page.html" class="btn btn-primary">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Favourite Plan: End -->

                    <!-- Standard Plan: Start -->
                    <div class="col-xl-4 col-lg-6">
                        <div class="card">
                            <div class="card-header">
                                <div class="text-center">
                                    <img src="{{ asset('assets/img/front-pages/icons/shuttle-rocket.png') }}"
                                        alt="shuttle rocket icon" class="pb-2 mb-8" />
                                    <h4 class="mb-0">Enterprise</h4>
                                    <div class="d-flex align-items-center justify-content-center">
                                        <span class="mb-0 price-monthly h2 text-primary fw-extrabold">$49</span>
                                        <span class="mb-0 price-yearly h2 text-primary fw-extrabold d-none">$37</span>
                                        <sub class="h6 text-body-secondary mb-n1 ms-1">/mo</sub>
                                    </div>
                                    <div class="pt-2 position-relative">
                                        <div class="price-yearly text-body-secondary price-yearly-toggle d-none">$ 444
                                            / year</div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <ul class="list-unstyled pricing-list">
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Everything in premium
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Timeline with database
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Fuzzy search
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            A/B testing sanbox
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Custom permissions
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Social media automation
                                        </h6>
                                    </li>
                                    <li>
                                        <h6 class="mb-3 d-flex align-items-center">
                                            <span class="p-0 badge badge-center rounded-pill bg-label-primary me-3"><i
                                                    class="icon-base ti tabler-check icon-12px"></i></span>
                                            Sales automation tools
                                        </h6>
                                    </li>
                                </ul>
                                <div class="mt-8 d-grid">
                                    <a href="payment-page.html" class="btn btn-label-primary">Get Started</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Standard Plan: End -->
                </div>
            </div>
        </section>
        <!-- Pricing plans: End -->

        <!-- Fun facts: Start -->
        <section id="landingFunFacts" class="section-py landing-fun-facts">
            <div class="container">
                <div class="row gy-6">
                    <!-- Homes Sold -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-primary">
                            <div class="text-center card-body">
                                <div class="mb-4 text-primary">
                                    <!-- Home Icon -->
                                    <svg width="64" height="65" fill="none" viewBox="0 0 64 64"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.2" d="M12 26L32 10L52 26V52H36V38H28V52H12V26Z"
                                            fill="currentColor" />
                                        <path d="M12 26L32 10L52 26V52H36V38H28V52H12V26Z" stroke="currentColor"
                                            stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <h3 class="mb-0">8,500+</h3>
                                <p class="mb-0 fw-medium">Homes<br />Sold Nationwide</p>
                            </div>
                        </div>
                    </div>

                    <!-- Verified Agents -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-success">
                            <div class="text-center card-body">
                                <div class="mb-4 text-success">
                                    <!-- Agent/User Icon -->
                                    <svg width="64" height="64" fill="none" viewBox="0 0 64 64"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <circle opacity="0.2" cx="32" cy="32" r="24"
                                            fill="currentColor" />
                                        <path
                                            d="M32 36C37.5228 36 42 31.5228 42 26C42 20.4772 37.5228 16 32 16C26.4772 16 22 20.4772 22 26C22 31.5228 26.4772 36 32 36Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M16 48C16 41.3726 22.3726 36 29 36H35C41.6274 36 48 41.3726 48 48"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <h3 class="mb-0">1,200+</h3>
                                <p class="mb-0 fw-medium">Verified Local<br />Agents</p>
                            </div>
                        </div>
                    </div>

                    <!-- User Ratings -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-info">
                            <div class="text-center card-body">
                                <div class="mb-4 text-info">
                                    <!-- Star Icon -->
                                    <svg width="64" height="64" fill="none" viewBox="0 0 64 64"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.2"
                                            d="M32 6L39.09 24.26L58 24.27L42 36.14L48.18 54L32 43.27L15.82 54L22 36.14L6 24.27L24.91 24.26L32 6Z"
                                            fill="currentColor" />
                                        <path
                                            d="M32 6L39.09 24.26L58 24.27L42 36.14L48.18 54L32 43.27L15.82 54L22 36.14L6 24.27L24.91 24.26L32 6Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <h3 class="mb-0">4.9/5</h3>
                                <p class="mb-0 fw-medium">Average User<br />Rating</p>
                            </div>
                        </div>
                    </div>

                    <!-- Secure Transactions -->
                    <div class="col-sm-6 col-lg-3">
                        <div class="border shadow-none card border-warning">
                            <div class="text-center card-body">
                                <div class="mb-4 text-warning">
                                    <!-- Shield Icon -->
                                    <svg width="64" height="64" fill="none" viewBox="0 0 64 64"
                                        xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.2"
                                            d="M32 6L56 16V32C56 47.464 45.333 58.667 32 62C18.667 58.667 8 47.464 8 32V16L32 6Z"
                                            fill="currentColor" />
                                        <path
                                            d="M32 6L56 16V32C56 47.464 45.333 58.667 32 62C18.667 58.667 8 47.464 8 32V16L32 6Z"
                                            stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                        <path d="M24 32L30 38L44 24" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                                <h3 class="mb-0">100%</h3>
                                <p class="mb-0 fw-medium">Secure & Verified<br />Transactions</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Fun facts: End -->


        <!-- FAQ: Start -->
        <section id="landingFAQ" class="section-py bg-body landing-faq">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">FAQ</span>
                </div>
                <h4 class="mb-1 text-center">
                    Frequently asked
                    <span class="position-relative fw-extrabold z-1">questions
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="hive icon"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                </h4>
                <p class="mb-12 text-center pb-md-4">
                    Browse through these FAQs to find answers to commonly asked questions about HiveHomes.
                </p>
                <div class="row gy-12 align-items-center">
                    <div class="col-lg-5">
                        <div class="text-center">
                            <img src="{{ asset('assets/img/front-pages/landing-page/faq-boy-with-logos.png') }}"
                                alt="faq boy with logos" class="faq-image" />
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="accordion" id="accordionExample">

                            <!-- FAQ 1 -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionOne" aria-expanded="true" aria-controls="accordionOne">
                                        <i class="icon-base ti tabler-currency-rupee me-2"></i>
                                        Is HiveHomes free to use?
                                    </button>
                                </h2>
                                <div id="accordionOne" class="accordion-collapse collapse"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Yes! HiveHomes is free for residents to join and use essential features. Premium
                                        tools may be available for societies that opt-in to advanced plans.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 2 -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingTwo">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionTwo" aria-expanded="false"
                                        aria-controls="accordionTwo">
                                        <i class="icon-base ti tabler-users-group me-2"></i>
                                        Who can join our HiveHomes society portal?
                                    </button>
                                </h2>
                                <div id="accordionTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Only verified residents and admins of your society can join your private
                                        HiveHomes space. Admins have tools to approve or invite members.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 3 -->
                            <div class="card accordion-item active">
                                <h2 class="accordion-header" id="headingThree">
                                    <button type="button" class="accordion-button" data-bs-toggle="collapse"
                                        data-bs-target="#accordionThree" aria-expanded="true"
                                        aria-controls="accordionThree">
                                        <i class="icon-base ti tabler-lock me-2"></i>
                                        Is my data secure on HiveHomes?
                                    </button>
                                </h2>
                                <div id="accordionThree" class="accordion-collapse collapse show"
                                    aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Absolutely. HiveHomes uses secure, encrypted protocols to store your data and
                                        restricts access only to authorized users and admins.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 4 -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFour">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFour" aria-expanded="false"
                                        aria-controls="accordionFour">
                                        <i class="icon-base ti tabler-building-community me-2"></i>
                                        Can HiveHomes be used by multiple societies?
                                    </button>
                                </h2>
                                <div id="accordionFour" class="accordion-collapse collapse" aria-labelledby="headingFour"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Yes! Each society gets its own secure and separate portal on HiveHomes.
                                        Societies operate independently while using the same powerful platform.
                                    </div>
                                </div>
                            </div>

                            <!-- FAQ 5 -->
                            <div class="card accordion-item">
                                <h2 class="accordion-header" id="headingFive">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse"
                                        data-bs-target="#accordionFive" aria-expanded="false"
                                        aria-controls="accordionFive">
                                        <i class="icon-base ti tabler-credit-card me-2"></i>
                                        How does payment collection work?
                                    </button>
                                </h2>
                                <div id="accordionFive" class="accordion-collapse collapse" aria-labelledby="headingFive"
                                    data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        Residents can pay maintenance bills and dues via secure online payments. Admins
                                        can track, generate receipts, and manage dues in real-time.
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- FAQ: End -->


        <!-- CTA: Start -->
        <section id="landingCTA" class="pb-0 section-py landing-cta position-relative p-lg-0">
            <img src="{{ asset('assets/img/front-pages/backgrounds/cta-bg-light.png') }}"
                class="bottom-0 position-absolute end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image"
                data-app-light-img="front-pages/backgrounds/cta-bg-light.png"
                data-app-dark-img="front-pages/backgrounds/cta-bg-dark.png" />
            <div class="container">
                <div class="row align-items-center gy-12">
                    <div class="col-lg-6 text-start text-sm-center text-lg-start">
                        <h3 class="mb-1 cta-title text-primary fw-bold">Ready to Get Started?</h3>
                        <h5 class="mb-8 text-body">Start your project with a 14-day free trial</h5>
                        <a href="payment-page.html" class="btn btn-lg btn-primary">Get Started</a>
                    </div>
                    <div class="text-center col-lg-6 pt-lg-12 text-lg-end">
                        <img src="{{ asset('assets/img/front-pages/landing-page/cta-dashboard.png') }}"
                            alt="cta dashboard" class="img-fluid mt-lg-4" />
                    </div>
                </div>
            </div>
        </section>
        <!-- CTA: End -->

        <!-- Contact Us: Start -->
        <section id="landingContact" class="section-py bg-body landing-contact">
            <div class="container">
                <div class="mb-4 text-center">
                    <span class="badge bg-label-primary">Contact US</span>
                </div>
                <h4 class="mb-1 text-center">
                    <span class="position-relative fw-extrabold z-1">Let's work
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}"
                            alt="laptop charging"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                    together
                </h4>
                <p class="mb-12 text-center pb-md-4">Any question or remark? just write us a message</p>
                <div class="row g-6">
                    <div class="col-lg-5">
                        <div class="p-2 border contact-img-box position-relative h-100">
                            <img src="{{ asset('assets/img/front-pages/icons/contact-border.png') }}"
                                alt="contact border"
                                class="contact-border-img position-absolute d-none d-lg-block scaleX-n1-rtl" />
                            <img src="{{ asset('assets/img/front-pages/landing-page/contact-customer-service.png') }}"
                                alt="contact customer service" class="contact-img w-100 scaleX-n1-rtl" />
                            <div class="p-4 pb-2">
                                <div class="row g-4">
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded badge bg-label-primary p-1_5 me-3">
                                                <i class="icon-base ti tabler-mail icon-lg"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Email</p>
                                                <h6 class="mb-0">
                                                    <a href="mailto:example@gmail.com"
                                                        class="text-heading">example@gmail.com</a>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 col-lg-12 col-xl-6">
                                        <div class="d-flex align-items-center">
                                            <div class="rounded badge bg-label-success p-1_5 me-3">
                                                <i class="icon-base ti tabler-phone-call icon-lg"></i>
                                            </div>
                                            <div>
                                                <p class="mb-0">Phone</p>
                                                <h6 class="mb-0"><a href="tel:+1234-568-963" class="text-heading">+1234
                                                        568 963</a></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7">
                        <div class="card h-100">
                            <div class="card-body">
                                <h4 class="mb-2">Send a message</h4>
                                <p class="mb-6">
                                    If you would like to discuss anything related to payment, account, licensing,<br
                                        class="d-none d-lg-block" />
                                    partnerships, or have pre-sales questions, you’re at the right place.
                                </p>
                                <form>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-fullname">Full Name</label>
                                            <input type="text" class="form-control" id="contact-form-fullname"
                                                placeholder="john" />
                                        </div>
                                        <div class="col-md-6">
                                            <label class="form-label" for="contact-form-email">Email</label>
                                            <input type="text" id="contact-form-email" class="form-control"
                                                placeholder="johndoe@gmail.com" />
                                        </div>
                                        <div class="col-12">
                                            <label class="form-label" for="contact-form-message">Message</label>
                                            <textarea id="contact-form-message" class="form-control" rows="7" placeholder="Write a message"></textarea>
                                        </div>
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-primary">Send inquiry</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Contact Us: End -->
    </div>
@endsection
@section('vendor-js')


@endsection
@section('page-js')

@endsection
