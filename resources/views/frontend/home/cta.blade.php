<section id="landingCTA" class="pb-0 section-py landing-cta position-relative p-lg-0">
    <img src="{{ asset('assets/img/front-pages/backgrounds/cta-bg-light.png') }}"
        class="bottom-0 position-absolute end-0 scaleX-n1-rtl h-100 w-100 z-n1" alt="cta image"
        data-app-light-img="front-pages/backgrounds/cta-bg-light.png"
        data-app-dark-img="front-pages/backgrounds/cta-bg-dark.png" />

    <div class="container">
        <div class="row align-items-center gy-12">
            <!-- Left Text Content -->
            <div class="col-lg-6 text-start text-sm-center text-lg-start">
                <h3 class="mb-1 cta-title text-primary fw-bold">Join Your Digital Society Today</h3>
                <h5 class="mb-4 text-body">Buy, sell, post, and connect with trusted neighbors — all within HiveHomes
                </h5>
                <a href="{{ route('register') }}" class="btn btn-lg btn-primary">Create Your Free Account</a>
            </div>

            <!-- Right Image -->
            <div class="text-center col-lg-6 pt-lg-12 text-lg-end">
                {{-- <img src="{{ asset('assets/img/front-pages/landing-page/cta-dashboard.png') }}" --}}
                <img src="{{ asset('assets/img/illustrations/page-misc-launching-soon.png') }}"
                    alt="HiveHomes dashboard preview" class="img-fluid" style="max-height: 250px" />
            </div>
        </div>
    </div>
</section>
