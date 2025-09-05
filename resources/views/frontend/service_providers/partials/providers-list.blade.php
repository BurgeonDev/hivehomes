<div class="row gy-4">
    @forelse($providers as $provider)
        <div class="col-md-6">
            <div class="card provider-card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    {{-- Header with Name, Type, Rating --}}
                    <div class="mb-2 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="mb-2 d-flex align-items-center">
                                @php
                                    $image = $provider->profile_image
                                        ? asset('storage/' . $provider->profile_image)
                                        : 'https://ui-avatars.com/api/?name=' .
                                            urlencode($provider->name) .
                                            '&background=random';
                                @endphp

                                <img src="{{ $image }}" alt="{{ $provider->name }}" class="rounded-circle me-3"
                                    width="80" height="80" style="object-fit:cover;">

                                <div>
                                    <h6 class="mb-0">{{ $provider->name }}</h6>
                                    @php
                                        $count = $provider->reviews_count ?? 0;
                                    @endphp
                                    <small class="text-muted">
                                        {{ $count }} review{{ $count !== 1 ? 's' : '' }}
                                    </small>
                                </div>
                            </div>

                        </div>

                        <div class="text-end">
                            <span
                                class="mb-1 badge bg-label-primary text-capitalize">{{ $provider->type->name ?? '-' }}</span>

                            {{-- average numeric + star icons --}}
                            @php
                                // reviews_avg_rating comes from withAvg('reviews','rating')
                                $avg =
                                    $provider->reviews_avg_rating !== null
                                        ? (float) $provider->reviews_avg_rating
                                        : 0.0;
                                $rounded = (int) round($avg); // approximate stars
                            @endphp

                            <div class="mt-1 d-flex align-items-center justify-content-end">
                                <span class="me-2 text-warning fw-bold">{{ number_format($avg, 1) }}</span>
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rounded)
                                            <i class="ti tabler-star-filled text-warning" aria-hidden="true"></i>
                                        @else
                                            <i class="ti tabler-star text-muted" aria-hidden="true"></i>
                                        @endif
                                    @endfor
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Bio Preview --}}
                    <p class="mb-3 small text-muted">{{ Str::limit($provider->bio, 80) }}</p>

                    {{-- Contact Info --}}
                    {{-- Contact Info --}}
                    <ul class="mb-0 list-unstyled small">
                        @if ($provider->phone)
                            <li><i class="menu-icon icon-base ti tabler-phone me-1"></i>{{ $provider->phone }}</li>
                        @endif
                        @if ($provider->email)
                            <li><i class="menu-icon icon-base ti tabler-mail me-1"></i>{{ $provider->email }}</li>
                        @endif
                    </ul>

                    {{-- Creator Info --}}
                    <div class="mt-2 small text-muted">
                        <i class="menu-icon icon-base ti tabler-user me-1"></i>
                        <span>Added by:</span>
                        <span class="fw-semibold text-dark">{{ $provider->creator->name ?? 'Unknown' }}</span>
                    </div>

                </div>

                {{-- Footer --}}
                <div class="card-footer border-top-0">
                    <a href="{{ route('service-providers.show', $provider->id) }}"
                        class="btn btn-sm btn-primary w-100">
                        <i class="menu-icon icon-base ti tabler-eye me-1"></i> View Profile
                    </a>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12">
            <div class="mb-0 alert alert-info">
                No service providers found.
            </div>
        </div>
    @endforelse
</div>

<div class="mt-4 d-flex justify-content-center">
    {{ $providers->links('pagination::bootstrap-5') }}
</div>
