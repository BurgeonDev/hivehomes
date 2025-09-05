<section id="landingServiceProviders" class="pb-0 section-py bg-body landing-services">
    <div class="container">
        <div class="mb-5 row align-items-center gx-0 gy-4 g-lg-5 pb-md-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
                <div class="mb-4">
                    <span class="badge bg-label-primary">Latest Service Providers</span>
                </div>
                <h4 class="mb-1">
                    <span class="position-relative fw-extrabold z-1">
                        Service Providers
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="services"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                </h4>
                <p class="mb-5 mb-md-12">
                    Find the latest approved service providers<br class="d-none d-xl-block" />
                    available in your community today.
                </p>
                <div>
                    <a href="{{ route('service-providers.index') }}" class="btn btn-label-primary">
                        See More
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-7 col-xl-9">
                <div class="row g-4">
                    @php
                        $query = \App\Models\ServiceProvider::where('is_approved', true)->where('is_active', true);

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('society_admin') || $user->hasRole('member')) {
                                $query->where('society_id', $user->society_id);
                            }
                        }

                        $providers = $query->latest()->take(8)->get();
                    @endphp

                    @forelse ($providers as $provider)
                        @php
                            $imagePath = $provider->profile_image
                                ? asset('storage/' . $provider->profile_image)
                                : asset('assets/img/front-pages/placeholder.png');
                        @endphp

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="text-center shadow-sm rounded-4 card h-100">
                                @if ($provider->profile_image)
                                    <img src="{{ asset('storage/' . $provider->profile_image) }}"
                                        alt="{{ $provider->name }}" class="rounded-top w-100 object-fit-cover"
                                        style="height: 160px;">
                                @else
                                    <div class="no-image-placeholder">No Image</div>
                                @endif


                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h6 class="mb-2 fw-bold text-truncate">{{ $provider->name }}</h6>
                                    <p class="mb-2 small text-muted text-truncate">{{ $provider->bio }}</p>
                                    <div class="mb-2 fw-semibold text-secondary">
                                        {{ optional($provider->type)->name ?? 'General Service' }}
                                    </div>

                                    <div class="mt-auto">
                                        <a href="{{ route('service-providers.show', $provider->id) }}"
                                            class="btn btn-sm btn-outline-primary w-100">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                    @empty
                        <p>No service providers available right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <hr class="m-0 mt-6 mt-md-12" />
</section>
