@extends('frontend.layouts.app')
@section('title', $provider->name)

@section('content')
    {{-- Banner / Breadcrumb --}}
    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 240px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">
        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('service-providers.index') }}" class="text-decoration-none text-dark">Service
                            Providers</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ Str::limit($provider->name, 40) }}
                    </li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-py bg-body first-section-pt">
        <div class="container">
            <div class="row g-4">
                {{-- Main content --}}
                <div class="col-lg-8">
                    <div class="mb-3 shadow-sm card">
                        <div class="p-4 card-body">
                            {{-- Header with Photo --}}
                            <div class="mb-4 d-flex align-items-center">
                                @if ($provider->profile_image)
                                    <img src="{{ asset('storage/' . $provider->profile_image) }}"
                                        alt="{{ $provider->name }}" class="rounded-circle me-3" width="80"
                                        height="80" style="object-fit:cover;">
                                @else
                                    <div class="text-white avatar avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center me-3"
                                        style="width:80px;height:80px;">
                                        {{ strtoupper(substr($provider->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <h2 class="mb-1">{{ $provider->name }}</h2>
                                    <span class="badge bg-label-primary text-capitalize">{{ $provider->type->name }}</span>
                                </div>
                            </div>

                            {{-- Contact & Details --}}
                            <div class="mb-4 row">
                                @if ($provider->phone)
                                    <div class="mb-2 col-md-6 d-flex align-items-center">
                                        <i class="menu-icon icon-base ti tabler-phone me-2"></i>
                                        <a href="tel:{{ $provider->phone }}">{{ $provider->phone }}</a>
                                    </div>
                                @endif
                                @if ($provider->email)
                                    <div class="mb-2 col-md-6 d-flex align-items-center">
                                        <i class="menu-icon icon-base ti tabler-mail me-2"></i>
                                        <a href="mailto:{{ $provider->email }}">{{ $provider->email }}</a>
                                    </div>
                                @endif
                                @if ($provider->address)
                                    <div class="mb-2 col-12 d-flex align-items-start">
                                        <i class="mt-1 menu-icon icon-base ti tabler-map-pin me-2"></i>
                                        <div>{{ $provider->address }}</div>
                                    </div>
                                @endif
                            </div>

                            {{-- Bio --}}
                            @if ($provider->bio)
                                <div class="mb-4">
                                    {!! nl2br(e($provider->bio)) !!}
                                </div>
                            @endif



                            {{-- Reviews List --}}
                            <div class="mb-5">
                                <h5 class="mb-3">Reviews ({{ $totalReviews }})</h5>
                                @forelse($provider->reviews()->latest()->get() as $review)
                                    <div class="mb-3 shadow-sm card">
                                        <div class="card-body">
                                            <div class="mb-2 d-flex align-items-center">
                                                <strong>{{ $review->user->name }}</strong>
                                                <small
                                                    class="text-muted ms-2">{{ $review->created_at->diffForHumans() }}</small>
                                                <span class="ms-auto text-warning">
                                                    {!! str_repeat('<i class="menu-icon icon-base ti tabler-star-filled"></i>', $review->rating) !!}
                                                </span>
                                            </div>
                                            <p class="mb-0">{{ $review->comment }}</p>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shadow-sm card">
                                        <div class="card-body">
                                            <p class="mb-0">No reviews yet.</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                    {{-- Review Form --}}
                    @auth
                        <div class="mb-4 shadow-sm card">
                            <div class="card-body">
                                <h5 class="mb-3">Leave a Review</h5>
                                <form action="{{ route('providers.reviews.store', ['service_provider' => $provider->id]) }}"
                                    method="POST">

                                    @csrf
                                    <div class="mb-3">
                                        <label class="form-label">Your Rating</label>
                                        <div class="gap-1 d-flex">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <input type="radio" class="btn-check" name="rating"
                                                    id="star{{ $i }}" value="{{ $i }}" required>
                                                <label class="btn btn-outline-warning" for="star{{ $i }}">
                                                    <i class="ti tabler-star"></i> {{ $i }}
                                                </label>
                                            @endfor
                                        </div>
                                        @error('rating')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Your Review</label>
                                        <textarea name="comment" class="form-control" rows="3" required></textarea>
                                        @error('comment')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary">Submit Review</button>
                                </form>
                            </div>
                        </div>
                    @else
                        <div class="mb-4 alert alert-info">
                            <a href="{{ route('login') }}">Log in</a> to leave a review.
                        </div>
                    @endauth
                </div>

                {{-- Sidebar --}}
                <div class="col-lg-4">
                    <div class="position-sticky" style="top:95px;">
                        {{-- Quick Info Card --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="card-body">
                                <h6 class="mb-2">Quick Info</h6>
                                <ul class="mb-0 list-unstyled small">
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Type:</strong>
                                        <span
                                            class="badge bg-label-info text-capitalize">{{ $provider->type->name }}</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Joined:</strong>
                                        <span class="badge bg-label-secondary">
                                            {{ optional($provider->created_at)->format('F j, Y') ?? 'N/A' }}
                                        </span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Status:</strong>
                                        <span
                                            class="badge {{ $provider->is_active ? 'bg-label-success' : 'bg-label-danger' }}">
                                            {{ $provider->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <strong> Added by:</strong>
                                        <span class="badge bg-label-dribbble">
                                            {{ $provider->creator->name ?? 'Unknown' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        {{-- Contact Buttons --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="p-3 text-center">
                                <a href="tel:{{ $provider->phone }}" class="mb-2 btn btn-sm btn-outline-primary w-100">
                                    <i class="menu-icon icon-base ti tabler-phone me-1"></i> Call
                                </a>
                                <a href="mailto:{{ $provider->email }}" class="btn btn-sm btn-primary w-100">
                                    <i class="menu-icon icon-base ti tabler-mail me-1"></i> Email
                                </a>
                            </div>
                        </div>

                        {{-- Rating Overview Card --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="card-body">
                                <h6 class="mb-3">Ratings Summary</h6>
                                <div class="mb-3 text-center">
                                    <h3 class="text-primary d-flex align-items-center justify-content-center">
                                        {{ number_format($averageRating, 2) }}
                                        <i class="ms-1 icon-base ti tabler-star-filled icon-32px"></i>
                                    </h3>
                                    <p class="mb-1 h6">Total {{ $totalReviews }} reviews</p>
                                    <p class="mb-1 text-muted small">All reviews are from genuine customers</p>
                                    <span class="badge bg-label-primary">+{{ $reviewsThisWeek }} This week</span>
                                </div>

                                @foreach ([5, 4, 3, 2, 1] as $star)
                                    <div class="mb-2 d-flex align-items-center">
                                        <small class="me-3">{{ $star }} Star</small>
                                        <div class="progress w-100 bg-label-primary" style="height: 8px">
                                            <div class="progress-bar bg-primary" role="progressbar"
                                                style="width: {{ $ratingDistribution[$star] ?? 0 }}%"
                                                aria-valuenow="{{ $ratingDistribution[$star] ?? 0 }}" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                        <small class="ms-2 text-end">{{ $ratingCounts[$star] ?? 0 }}</small>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

            </div>


        </div>
    </section>
@endsection
