<style>
    /* Animations */
    @keyframes fadeUp {
        0% {
            opacity: 0;
            transform: translateY(30px);
        }

        100% {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes bounceIn {
        0% {
            transform: scale(0.3);
            opacity: 0;
        }

        50% {
            transform: scale(1.1);
            opacity: 1;
        }

        70% {
            transform: scale(0.95);
        }

        100% {
            transform: scale(1);
        }
    }

    .hero-title {
        animation: fadeUp 0.8s ease forwards;
    }

    .hero-text-box h3,
    .hero-text-box p,
    .hero-text-box a {
        opacity: 0;
        animation: fadeUp 1s ease forwards;
    }

    .hero-text-box h3 {
        animation-delay: 0.2s;
    }

    .hero-text-box p {
        animation-delay: 0.4s;
    }

    .hero-text-box a {
        animation-delay: 0.6s;
    }

    .hero-title i {
        display: inline-block;
        animation: bounceIn 1s ease forwards;
        animation-delay: 0.5s;
    }

    /* Feature cards */
    .feature-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        animation: fadeUp 0.8s ease forwards;
        opacity: 0;
    }

    .feature-card:hover {
        transform: translateY(-8px) scale(1.02);
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
    }

    .feature-icon {
        display: inline-block;
        animation: bounceIn 1s ease forwards;
    }

    /* Animate cards sequentially */
    .feature-card:nth-child(1) {
        animation-delay: 0.2s;
    }

    .feature-card:nth-child(2) {
        animation-delay: 0.4s;
    }

    .feature-card:nth-child(3) {
        animation-delay: 0.6s;
    }
</style>

<section id="hero-animation">
    <div id="landingHero" class="section-py landing-hero position-relative bg-light">
        <div class="container">
            <div class="text-center hero-text-box position-relative">
                <h1 class="text-primary hero-title display-5 fw-extrabold">
                    HiveHomes <i class="icon-base ti tabler-home icon-xl" style="width:35px; height: 35px;"></i>
                </h1>
                <h3 class="mb-3 text-dark fw-bold">
                    Simplify Life in Your Society
                </h3>
                <p class="mb-4 text-secondary lead">
                    A modern platform for connected communities — enabling smooth communication,
                    local commerce, and effortless access to trusted services.
                </p>
                @if (auth()->check())
                    <a href="{{ route('posts.index') }}" class="px-5 btn btn-primary btn-lg">
                        Explore My Society Updates
                    </a>
                @else
                    <a href="{{ route('register') }}" class="px-5 btn btn-primary btn-lg">
                        Join Your Society Now
                    </a>
                @endif
            </div>


            <!-- Features: Start -->
            <div class="mt-5 text-center row g-4">

                <!-- Posts -->
                <div class="col-md-4">
                    <a href="{{ route('posts.index') }}" class="text-decoration-none text-dark">
                        <div class="bg-transparent border-0 rounded-4 card h-100 feature-card">
                            <div class="card-body">
                                <div class="mb-3 text-primary feature-icon">
                                    <i class="mb-2 icon-base ti tabler-brand-slack icon-xl"></i>
                                </div>
                                <h5 class="fw-bold">Community Updates</h5>
                                <p class="text-muted">
                                    Stay in the loop with notices, events, emergencies, and announcements — all in one
                                    place.
                                </p>
                                <span class="text-primary fw-bold">Go to Posts →</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Products -->
                <div class="col-md-4">
                    <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">
                        <div class="bg-transparent border-0 rounded-4 card h-100 feature-card">
                            <div class="card-body">
                                <div class="mb-3 text-success feature-icon">
                                    <i class="icon-base ti tabler-shopping-cart fs-1 icon-xl"></i>
                                </div>
                                <h5 class="fw-bold">Buy & Sell Locally</h5>
                                <p class="text-muted">
                                    Discover a built-in marketplace for members to sell used items or find great local
                                    deals.
                                </p>
                                <span class="text-success fw-bold">Go to Products →</span>
                            </div>
                        </div>
                    </a>
                </div>

                <!-- Service Providers -->
                <div class="col-md-4">
                    <a href="{{ route('service-providers.index') }}" class="text-decoration-none text-dark">
                        <div class="bg-transparent border-0 rounded-4 card h-100 feature-card">
                            <div class="card-body">
                                <div class="mb-3 text-warning feature-icon">
                                    <i class="icon-base ti tabler-users fs-1 icon-xl"></i>
                                </div>
                                <h5 class="fw-bold">Find Trusted Help</h5>
                                <p class="text-muted">
                                    Need a plumber, electrician, or tutor? Browse a list of verified service providers
                                    in your area.
                                </p>
                                <span class="text-warning fw-bold">Go to Services →</span>
                            </div>
                        </div>
                    </a>
                </div>

            </div>
            <!-- Features: End -->



        </div>
    </div>
