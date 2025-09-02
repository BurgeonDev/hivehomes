@extends('frontend.layouts.app')
@section('title', 'Dashboard')

@section('content')
    @php
        // compute initials and bg color
        $name = trim($user->name ?? '');
        $parts = preg_split('/\s+/', $name);
        $initials = strtoupper(($parts[0][0] ?? '') . ($parts[1][0] ?? ($parts[0][1] ?? '')));
        // deterministic color from user id/email
        $hash = md5(($user->id ?? '') . ($user->email ?? ''));
        $bgColor = '#' . substr($hash, 0, 6);
    @endphp

    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 200px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">
        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-5">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-decoration-none text-primary">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">User Dashboard</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-py">
        <div class="container-fluid">
            <div class="row">

                <!-- LEFT SIDEBAR -->
                <div class="mb-4 col-lg-3">
                    <div class="mb-6 card">
                        <div class="pt-12 text-center card-body">
                            <!-- Initials Avatar -->
                            <div class="d-flex align-items-center flex-column">
                                <div
                                    style="width:120px;height:120px;border-radius:999px;display:flex;align-items:center;justify-content:center;font-size:36px;color:#fff;background:{{ $bgColor }};margin:0 auto 16px;">
                                    {{ $initials ?: 'U' }}
                                </div>
                                <div class="user-info">
                                    <h5 class="mb-1">{{ $user->name ?? 'User' }}</h5>
                                    <span class="badge bg-label-secondary">{{ $user->role ?? 'Member' }}</span>
                                </div>
                            </div>

                            <!-- Small Stats -->
                            <div class="flex-wrap gap-3 my-6 d-flex justify-content-around">
                                <div class="gap-3 d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <div class="rounded avatar-initial bg-label-primary">
                                            <i class="ti ti-notebook"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $counts['posts'] ?? 0 }}</h5>
                                        <span>Posts</span>
                                    </div>
                                </div>
                                <div class="gap-3 d-flex align-items-center">
                                    <div class="avatar me-2">
                                        <div class="rounded avatar-initial bg-label-primary">
                                            <i class="ti ti-shopping-cart"></i>
                                        </div>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">{{ $counts['products'] ?? 0 }}</h5>
                                        <span>Products</span>
                                    </div>
                                </div>
                            </div>

                            <!-- User Details -->
                            <h5 class="pb-3 mb-3 border-bottom">Details</h5>
                            <ul class="mb-4 list-unstyled text-start">
                                <li class="mb-2"><span class="h6">Username:</span>
                                    <span>{{ '@' . ($user->username ?? 'n/a') }}</span></li>
                                <li class="mb-2"><span class="h6">Email:</span> <span>{{ $user->email }}</span></li>
                                <li class="mb-2"><span class="h6">Status:</span>
                                    <span>{{ $user->status ?? 'Active' }}</span></li>
                                <li class="mb-2"><span class="h6">Role:</span>
                                    <span>{{ $user->role ?? 'Member' }}</span></li>
                                <li class="mb-2"><span class="h6">Joined:</span>
                                    <span>{{ optional($user->created_at)->format('M Y') }}</span></li>
                            </ul>

                            <!-- Edit profile button only -->
                            <div class="d-flex justify-content-center">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- RIGHT CONTENT -->
                <div class="col-lg-9">
                    <!-- Tabs -->
                    <div class="mb-4 nav-align-top">
                        <ul class="flex-wrap row-gap-2 nav nav-pills flex-column flex-md-row" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill" href="#tab-dashboard" role="tab"
                                    aria-selected="true">
                                    <i class="ti ti-chart-pie me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-products" role="tab">
                                    <i class="ti ti-shopping-cart me-2"></i> Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-posts" role="tab">
                                    <i class="ti ti-notebook me-2"></i> Posts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-reviews" role="tab">
                                    <i class="ti ti-message me-2"></i> Service Reviews
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">
                        {{-- DASHBOARD --}}
                        <div id="tab-dashboard" class="tab-pane fade show active">
                            <div class="p-4 mb-4 shadow-sm card">
                                <h5 class="mb-4">Dashboard Overview</h5>
                                <div class="row g-4">
                                    <div class="col-md-6 col-xl-4">
                                        <div class="border-0 shadow-sm card h-100">
                                            <div class="text-center card-body">
                                                <i class="mb-3 ti ti-notebook text-primary" style="font-size: 40px;"></i>
                                                <h6>Your Posts</h6>
                                                <p>{{ $counts['posts'] ?? 0 }} total</p>
                                                <div class="gap-2 d-flex justify-content-center">
                                                    <span class="badge bg-success">Approved:
                                                        {{ $postStatuses['approved'] ?? 0 }}</span>
                                                    <span class="badge bg-warning text-dark">Pending:
                                                        {{ $postStatuses['pending'] ?? 0 }}</span>
                                                    <span class="badge bg-danger">Rejected:
                                                        {{ $postStatuses['rejected'] ?? 0 }}</span>
                                                </div>
                                                <a href="#tab-posts" class="mt-3 btn btn-sm btn-outline-primary"
                                                    data-bs-toggle="pill">View Posts</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <div class="border-0 shadow-sm card h-100">
                                            <div class="text-center card-body">
                                                <i class="mb-3 ti ti-shopping-cart text-success"
                                                    style="font-size: 40px;"></i>
                                                <h6>Your Products</h6>
                                                <p>{{ $counts['products'] ?? 0 }} listed</p>
                                                <a href="#tab-products" class="btn btn-sm btn-outline-success"
                                                    data-bs-toggle="pill">View Products</a>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-xl-4">
                                        <div class="border-0 shadow-sm card h-100">
                                            <div class="text-center card-body">
                                                <i class="mb-3 ti ti-message-circle text-warning"
                                                    style="font-size: 40px;"></i>
                                                <h6>Your Comments</h6>
                                                <p>{{ $counts['comments'] ?? 0 }} written</p>
                                                <a href="#" class="btn btn-sm btn-outline-warning">View</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- PRODUCTS --}}
                        <div id="tab-products" class="tab-pane fade">
                            <div class="p-4 mb-4 shadow-sm card">
                                <h5 class="mb-4">Your Products</h5>

                                @if ($products->count())
                                    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-3">
                                        @foreach ($products as $product)
                                            <div class="col">
                                                <div class="card h-100">
                                                    <div class="card-body">
                                                        <h6 class="card-title">{{ $product->name }}</h6>
                                                        <p class="mb-2 card-text small">
                                                            {{ Str::limit($product->description ?? '', 80) }}</p>
                                                        <div class="d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">Stock:
                                                                {{ $product->stock ?? 'N/A' }}</small>
                                                            <a href="{{ route('products.edit', $product->id) }}"
                                                                class="btn btn-sm btn-outline-primary">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3">
                                        {{ $products->links() }}
                                    </div>
                                @else
                                    <p class="text-muted">You don't have any products yet.</p>
                                @endif
                            </div>
                        </div>

                        {{-- POSTS --}}
                        <div id="tab-posts" class="tab-pane fade">
                            <div class="p-4 mb-4 shadow-sm card">
                                <h5 class="mb-4">Your Posts</h5>

                                @if ($posts->count())
                                    <div class="list-group">
                                        @foreach ($posts as $post)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <h6 class="mb-1">{{ $post->title }}</h6>
                                                        <small
                                                            class="text-muted">{{ $post->created_at->diffForHumans() }}</small>
                                                        <p class="mt-1 mb-0 small text-truncate">
                                                            {{ Str::limit($post->excerpt ?? ($post->body ?? ''), 120) }}</p>
                                                    </div>
                                                    <div class="text-end">
                                                        <span
                                                            class="badge @if ($post->status == 'approved') bg-success @elseif($post->status == 'pending') bg-warning text-dark @else bg-danger @endif mb-2">
                                                            {{ ucfirst($post->status ?? 'N/A') }}
                                                        </span>
                                                        <div>
                                                            <a href="{{ route('posts.edit', $post->id) }}"
                                                                class="btn btn-sm btn-outline-secondary">Edit</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3">
                                        {{ $posts->links() }}
                                    </div>
                                @else
                                    <p class="text-muted">You don't have any posts yet.</p>
                                @endif
                            </div>
                        </div>

                        {{-- REVIEWS --}}
                        <div id="tab-reviews" class="tab-pane fade">
                            <div class="p-4 mb-4 shadow-sm card">
                                <h5 class="mb-4">Service Reviews</h5>

                                @if ($serviceReviews->count())
                                    <div class="list-group">
                                        @foreach ($serviceReviews as $review)
                                            <div class="list-group-item">
                                                <div class="d-flex justify-content-between">
                                                    <div>
                                                        <strong>{{ $review->title ?? Str::limit($review->body, 40) }}</strong>
                                                        <div class="small text-muted">By
                                                            {{ $review->user->name ?? 'Anonymous' }} —
                                                            {{ $review->created_at->diffForHumans() }}</div>
                                                        <p class="mt-1 mb-0 small">{{ Str::limit($review->body, 140) }}
                                                        </p>
                                                    </div>
                                                    <div class="text-end">
                                                        <div class="mb-1">Rating: {{ $review->rating ?? '—' }}</div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="mt-3">
                                        {{ $serviceReviews->links() }}
                                    </div>
                                @else
                                    <p class="text-muted">No reviews found for your services.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <!-- END Tab Content -->
                </div>
            </div>
        </div>
    </section>
@endsection
