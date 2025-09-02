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

    <!-- Local styles to polish dashboard -->
    <style>
        /* Professional card shadows + spacing */
        .dashboard-card {
            border: 0;
            border-radius: 12px;
            box-shadow: 0 6px 18px rgba(19, 33, 68, 0.06);
        }

        .avatar-circle {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 36px;
            color: #fff;
            margin: 0 auto 16px;
        }

        .stat-box {
            border-radius: 10px;
            padding: 16px;
            min-width: 140px;
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 22px;
            color: #fff;
        }

        .muted {
            color: #6c757d;
        }

        .small-meta {
            font-size: .9rem;
            color: #6c757d;
        }

        .tabler-icon-lg {
            font-size: 40px;
        }

        .nav-pills .nav-link {
            border-radius: 10px;
            padding: .6rem 1rem;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            font-size: 1.25rem;
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .dashboard-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 6px 16px rgba(0, 0, 0, 0.15);
        }


        /* responsive adjustments */
        @media (max-width: 991px) {
            .stat-grid {
                gap: 10px;
            }

            .avatar-circle {
                width: 96px;
                height: 96px;
                font-size: 32px;
            }
        }
    </style>

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
            <div class="row g-4">

                <!-- LEFT SIDEBAR -->
                <aside class="col-lg-3">
                    <div class="mb-4 card dashboard-card">
                        <div class="pt-5 text-center card-body">
                            <!-- Initials Avatar -->
                            <div class="d-flex align-items-center flex-column">
                                <div class="avatar-circle" style="background: {{ $bgColor }};">
                                    {{ $initials ?: 'U' }}
                                </div>

                                <div class="user-info">
                                    <h5 class="mb-1">{{ $user->name ?? 'User' }}</h5>
                                    <span class="badge bg-label-secondary">{{ $user->role ?? 'Member' }}</span>
                                </div>
                            </div>

                            <!-- User Details -->
                            <div class="mb-3">
                                <h6 class="mb-2">User Info</h6>
                                <ul class="mb-0 list-unstyled small">
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Phone:</strong>
                                        <span class="badge bg-label-primary">{{ $user->phone ?? 'N/A' }}</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Email:</strong>
                                        <span class="badge bg-label-info">{{ $user->email ?? '—' }}</span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Status:</strong>
                                        <span
                                            class="badge {{ ($user->status ?? 'Active') === 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                            {{ $user->status ?? 'Active' }}
                                        </span>
                                    </li>
                                    <li class="mb-2 d-flex justify-content-between align-items-center">
                                        <strong>Role:</strong>
                                        <span
                                            class="badge bg-label-secondary text-capitalize">{{ $user->role ?? 'Member' }}</span>
                                    </li>
                                    <li class="d-flex justify-content-between align-items-center">
                                        <strong>Joined:</strong>
                                        <span class="badge bg-label-dark">
                                            {{ optional($user->created_at)->format('M Y') ?? 'N/A' }}
                                        </span>
                                    </li>
                                </ul>
                            </div>

                            <div class="d-flex justify-content-center">
                                <a href="{{ route('profile.update') }}" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </aside>

                <!-- RIGHT CONTENT -->
                <main class="col-lg-9">
                    <!-- Tabs -->
                    <div class="mb-4 nav-align-top">
                        <ul class="gap-2 nav nav-pills flex-column flex-md-row" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" data-bs-toggle="pill" href="#tab-dashboard" role="tab"
                                    aria-selected="true">
                                    <i class="icon-base ti tabler-dashboard me-2"></i> Dashboard
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-products" role="tab">
                                    <i class="icon-base ti tabler-box me-2"></i> Products
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-posts" role="tab">
                                    <i class="icon-base ti tabler-file-text me-2"></i> Posts
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-bs-toggle="pill" href="#tab-reviews" role="tab">
                                    <i class="icon-base ti tabler-star me-2"></i> Service Reviews
                                </a>
                            </li>
                        </ul>
                    </div>

                    <!-- Tab Content -->
                    <div class="tab-content">

                        {{-- DASHBOARD --}}
                        <div id="tab-dashboard" class="tab-pane fade show active">
                            <div class="col-xl-12 col-md-12">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between align-items-center">
                                        <div>
                                            <h3 class="mb-0 card-title d-flex align-items-center">
                                                <i class="icon-base ti tabler-dashboard me-2"></i>
                                                Dashboard Overview
                                            </h3>
                                            <small class="text-muted">At a glance — quick metrics and health</small>
                                        </div>

                                        <div class="text-end">
                                            <small class="text-body-secondary">Updated just now</small>
                                        </div>
                                    </div>

                                    <div class="card-body">
                                        <div class="w-100">

                                            {{-- ====== POSTS SECTION ====== --}}
                                            <div class="mb-4">
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="p-2 text-white me-3 rounded-circle bg-label-primary d-flex align-items-center justify-content-center"
                                                            style="width:44px;height:44px;">
                                                            <i class="icon-base ti tabler-file-text"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Posts</h5>
                                                            <small class="text-muted">Content creation & moderation</small>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('posts.index') }}"
                                                            class="btn btn-sm btn-outline-secondary">View posts</a>
                                                    </div>
                                                </div>

                                                <div class="row gy-3">
                                                    <!-- Total Posts -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-primary">
                                                                <i class="icon-base ti tabler-file-text icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $counts['posts'] ?? 0 }}</h5>
                                                                <small class="text-muted">Total Posts</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pending Posts -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-warning">
                                                                <i class="icon-base ti tabler-hourglass icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $postStatuses['pending'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Pending</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Approved Posts -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-success">
                                                                <i class="icon-base ti tabler-circle-check icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $postStatuses['approved'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Approved</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rejected Posts -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-danger">
                                                                <i class="icon-base ti tabler-circle-x icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $postStatuses['rejected'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Rejected</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            {{-- ====== PRODUCTS SECTION ====== --}}
                                            <div class="mb-4">
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="p-2 text-white me-3 rounded-circle bg-label-info d-flex align-items-center justify-content-center"
                                                            style="width:44px;height:44px;">
                                                            <i class="icon-base ti tabler-package"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Products</h5>
                                                            <small class="text-muted">Inventory status & approvals</small>
                                                        </div>
                                                    </div>

                                                    <div>
                                                        <a href="{{ route('products.index') }}"
                                                            class="btn btn-sm btn-outline-secondary">View products</a>
                                                    </div>
                                                </div>

                                                <div class="row gy-3">
                                                    <!-- Total Products -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-info">
                                                                <i class="icon-base ti tabler-package icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $counts['products'] ?? 0 }}</h5>
                                                                <small class="text-muted">Total Products</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Pending Products -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-warning">
                                                                <i class="icon-base ti tabler-hourglass icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $productStatuses['pending'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Pending</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Approved Products -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-success">
                                                                <i class="icon-base ti tabler-circle-check icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $productStatuses['approved'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Approved</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Rejected Products -->
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-danger">
                                                                <i class="icon-base ti tabler-circle-x icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $productStatuses['rejected'] ?? 0 }}
                                                                </h5>
                                                                <small class="text-muted">Rejected</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-4">

                                            {{-- ====== ENGAGEMENT SECTION ====== --}}
                                            <!--    <div>
                                                    <div class="mb-3 d-flex align-items-center justify-content-between">
                                                        <div class="d-flex align-items-center">
                                                            <div class="p-2 text-white me-3 rounded-circle bg-label-secondary d-flex align-items-center justify-content-center"
                                                                style="width:44px;height:44px;">
                                                                <i class="icon-base ti tabler-message-circle"></i>
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-0">Engagement</h5>
                                                                <small class="text-muted">Comments, likes and community
                                                                    pulse</small>
                                                            </div>
                                                        </div>

                                                    </div>

                                                    <div class="row gy-3">
                                                        <div class="col-md-3 col-6">
                                                            <div
                                                                class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                                <div class="p-2 rounded me-3 badge bg-label-secondary">
                                                                    <i class="icon-base ti tabler-message-circle icon-lg"></i>
                                                                </div>
                                                                <div class="card-info">
                                                                    <h5 class="mb-0">{{ $counts['comments'] ?? 0 }}</h5>
                                                                    <small class="text-muted">Comments</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-3 col-6">
                                                            <div
                                                                class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                                <div class="p-2 rounded me-3 badge bg-label-primary">
                                                                    <i class="icon-base ti tabler-thumb-up icon-lg"></i>
                                                                </div>
                                                                <div class="card-info">
                                                                    <h5 class="mb-0">{{ $counts['likes_received'] ?? 0 }}
                                                                    </h5>
                                                                    <small class="text-muted">Likes Received</small>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- add more engagement KPIs here if needed --}}
                                                    </div>
                                                </div>
                                            -->


                                        </div> <!-- w-100 -->
                                    </div> <!-- card-body -->
                                </div> <!-- card -->
                            </div> <!-- col -->
                        </div> <!-- tab -->



                        {{-- PRODUCTS --}}
                        <div id="tab-products" class="tab-pane fade">
                            <div class="mb-4 card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Your Products</h5>
                                    <small class="text-body-secondary">Total: {{ $counts['products'] ?? 0 }}</small>
                                </div>

                                <div class="card-body">
                                    @if ($products->count())
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                            @foreach ($products as $product)
                                                <div class="col">
                                                    <div class="border-0 shadow-sm card h-100 rounded-4">
                                                        {{-- Optional image (uncomment if available) --}}
                                                        {{-- @if ($product->thumbnail) <img src="{{ $product->thumbnail }}" class="card-img-top rounded-top-4" alt="{{ $product->title }}"> @endif --}}

                                                        {{-- Product Header --}}
                                                        <div
                                                            class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
                                                            <h6 class="mb-0 fw-bold text-truncate"
                                                                title="{{ $product->title }}">{{ $product->title }}</h6>

                                                            <span
                                                                class="badge
                    @if ($product->status == 'approved') bg-label-success
                    @elseif($product->status == 'pending') bg-label-warning
                    @else bg-label-danger @endif">
                                                                {{ ucfirst($product->status ?? 'N/A') }}
                                                            </span>
                                                        </div>

                                                        {{-- Product Body --}}
                                                        <div class="card-body d-flex flex-column">

                                                            <p class="mb-3 card-text small text-muted">
                                                                {{ Str::limit($product->description ?? 'No description', 120) }}
                                                            </p>



                                                            <div
                                                                class="mt-auto d-flex justify-content-between align-items-center">
                                                                <div>
                                                                    <span class="badge bg-label-info me-2">
                                                                        <i class="icon-base ti tabler-package me-1"></i>
                                                                        {{ $product->price ?? 'N/A' }}
                                                                    </span>
                                                                    <small class="text-muted ms-1">Quantity:
                                                                        {{ $product->quantity ?? '—' }}</small>
                                                                </div>

                                                                <div class="text-end">
                                                                    <a href="{{ route('products.show', $product) }}"
                                                                        class="btn btn-sm btn-outline-primary">View</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Footer with small meta --}}
                                                        <div
                                                            class="bg-transparent border-0 card-footer d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">Added
                                                                {{ $product->created_at->diffForHumans() }}</small>
                                                            <small class="text-muted"><i
                                                                    class="icon-base ti tabler-eye me-1"></i>{{ $product->views ?? 0 }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Pagination --}}
                                        <div class="mt-4">
                                            {{ $products->links() }}
                                        </div>
                                    @else
                                        <div class="py-4 text-center text-muted">
                                            <i class="mb-2 ti tabler-package icon-lg"></i>
                                            <p class="mb-0">You don't have any products yet.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        {{-- POSTS --}}
                        <div id="tab-posts" class="tab-pane fade">
                            <div class="mb-4 card">
                                <div class="card-header d-flex justify-content-between align-items-center">
                                    <h5 class="mb-0">Your Posts</h5>
                                    <small class="text-body-secondary">Total: {{ $counts['posts'] ?? 0 }}</small>
                                </div>

                                <div class="card-body">
                                    @if ($posts->count())
                                        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                                            @foreach ($posts as $post)
                                                <div class="col">
                                                    <div class="border-0 shadow-sm card h-100 rounded-4">

                                                        {{-- Post Header --}}
                                                        <div
                                                            class="card-header bg-light d-flex justify-content-between align-items-center rounded-top-4">
                                                            <h6 class="mb-0 fw-bold text-truncate"
                                                                title="{{ $post->title }}">{{ $post->title }}</h6>

                                                            <span
                                                                class="badge
                    @if ($post->status == 'approved') bg-label-success
                    @elseif($post->status == 'pending') bg-label-warning
                    @else bg-label-danger @endif">
                                                                {{ ucfirst($post->status ?? 'N/A') }}
                                                            </span>
                                                        </div>

                                                        {{-- Post Body --}}
                                                        <div class="card-body d-flex flex-column">
                                                            <small class="mb-2 text-muted d-block">
                                                                <i class="icon-base ti tabler-calendar-time me-1"></i>
                                                                {{ $post->created_at->diffForHumans() }}

                                                            </small>
                                                            <div class="mb-3 card-text small text-muted">
                                                                {!! Str::limit($post->body ?? '<em>No content</em>', 200) !!}
                                                            </div>

                                                            <div
                                                                class="mt-auto d-flex justify-content-between align-items-center">
                                                                <span class="badge bg-label-primary">
                                                                    <i class="icon-base ti tabler-message-circle me-1"></i>
                                                                    {{ $post->comments->count() ?? 0 }} Comments
                                                                </span>

                                                                <div class="gap-2 d-flex align-items-center">
                                                                    <span class="badge bg-label-danger">
                                                                        <i class="icon-base ti tabler-heart me-1"></i>
                                                                        {{ $post->likes_count ?? $post->likedByUsers->count() }}
                                                                        Likes
                                                                    </span>

                                                                    <a href="{{ route('posts.show', $post) }}"
                                                                        class="btn btn-sm btn-outline-primary">Read</a>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        {{-- Footer --}}
                                                        <div
                                                            class="bg-transparent border-0 card-footer d-flex justify-content-between align-items-center">
                                                            <small class="text-muted">By
                                                                {{ $post->author->name ?? ($post->user->name ?? 'You') }}</small>
                                                            <small class="text-muted"><i
                                                                    class="icon-base ti tabler-eye me-1"></i>{{ $post->views ?? 0 }}</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>

                                        {{-- Pagination --}}
                                        <div class="mt-4">
                                            {{ $posts->links() }}
                                        </div>
                                    @else
                                        <div class="py-4 text-center text-muted">
                                            <i class="mb-2 ti tabler-file-text icon-lg"></i>
                                            <p class="mb-0">You don't have any posts yet.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>



                        {{-- REVIEWS --}}
                        <div id="tab-reviews" class="tab-pane fade">
                            <div class="p-3 mb-4 card dashboard-card">
                                <h5 class="mb-3">Service Reviews</h5>

                                @if ($serviceReviews->count())
                                    <div class="row g-3">
                                        @foreach ($serviceReviews as $review)
                                            <div class="col-md-6">
                                                <div class="shadow-sm card h-100 rounded-4">
                                                    <div class="card-body">
                                                        {{-- Provider link --}}
                                                        <h6 class="mb-2">
                                                            <a href="{{ route('service-providers.show', $review->provider->id) }}"
                                                                class="text-decoration-none fw-bold">
                                                                {{ $review->provider->name }}
                                                            </a>
                                                        </h6>

                                                        {{-- Star Rating --}}
                                                        <div class="mb-2 text-warning">
                                                            @for ($i = 1; $i <= 5; $i++)
                                                                <i
                                                                    class="icon-base ti tabler-star{{ $i <= $review->rating ? '' : '-off' }}"></i>
                                                            @endfor
                                                            <small class="text-muted">({{ $review->rating }}/5)</small>
                                                        </div>

                                                        {{-- Comment --}}
                                                        <p class="mb-2">{{ Str::limit($review->comment, 140) }}</p>

                                                        {{-- Reviewer Info --}}
                                                        <div class="small text-muted">
                                                            By <strong>{{ $review->user->name ?? 'Anonymous' }}</strong>
                                                            • {{ $review->created_at->diffForHumans() }}
                                                        </div>
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
                </main>
            </div>
        </div>
    </section>
@endsection
