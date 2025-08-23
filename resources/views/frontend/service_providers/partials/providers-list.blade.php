<div class="row gy-4">
    @forelse($providers as $provider)
        <div class="col-md-6">
            <div class="card provider-card h-100 d-flex flex-column">
                <div class="card-body flex-grow-1">
                    {{-- Header with Name, Type, Rating --}}
                    <div class="mb-2 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="mb-2 d-flex align-items-center">
                                <img src="{{ $provider->profile_picture ? asset('storage/' . $provider->profile_picture) : 'https://ui-avatars.com/api/?name=' . urlencode($provider->name) . '&background=random' }}"
                                    alt="Profile Picture" class="rounded-circle me-2" width="40" height="40"
                                    style="object-fit: cover;">

                                <div>
                                    <h6 class="mb-0">{{ $provider->name }}</h6>
                                    <small class="text-muted">
                                        {{ $provider->total_reviews }}
                                        review{{ $provider->total_reviews !== 1 ? 's' : '' }}
                                    </small>
                                </div>
                            </div>

                            <h6 class="mb-0">{{ $provider->name }}</h6>
                            <small class="text-muted">
                                {{ $provider->total_reviews }} review{{ $provider->total_reviews !== 1 ? 's' : '' }}
                            </small>
                        </div>
                        <div class="text-end">
                            <span class="mb-1 badge bg-label-primary text-capitalize">{{ $provider->type->name }}</span>
                            <div class="d-flex align-items-center justify-content-end">
                                <span class="me-1 text-warning fw-bold">
                                    {{ number_format($provider->average_rating, 1) }}
                                </span>
                                <i class="ti tabler-star-filled text-warning"></i>
                            </div>
                        </div>
                    </div>

                    {{-- Bio Preview --}}
                    <p class="mb-3 small text-muted">{{ Str::limit($provider->bio, 80) }}</p>

                    {{-- Contact Info --}}
                    <ul class="mb-0 list-unstyled small">
                        @if ($provider->phone)
                            <li><i class="menu-icon icon-base ti tabler-phone me-1"></i>{{ $provider->phone }}</li>
                        @endif
                        @if ($provider->email)
                            <li><i class="menu-icon icon-base ti tabler-mail me-1"></i>{{ $provider->email }}</li>
                        @endif
                    </ul>
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
