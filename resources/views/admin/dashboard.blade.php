@extends('admin.layouts.app')
@section('title', 'Dashboard')
@section('vendor-css')

@endsection
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/cards-advance.css') }}" />
@endsection

@section('content')


    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-6">
            <!-- Post Analytics -->
            <div class="col-xl-6 col">
                <div class="swiper-container swiper-container-horizontal swiper swiper-card-advance-bg"
                    id="swiper-with-pagination-cards">
                    <div class="swiper-wrapper">
                        <div class="swiper-slide">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-0 text-white">Post Analytics</h5>
                                    <small>Total {{ $approvalRate }}% Approval Rate</small>
                                </div>
                                <div class="row">
                                    <div class="order-2 col-lg-7 col-md-9 col-12 order-md-1 pt-md-9">
                                        <h6 class="mt-0 mb-4 text-white mt-md-3">Post Activity</h6>
                                        <div class="row">
                                            <div class="col-6">
                                                <ul class="mb-0 list-unstyled">
                                                    <li class="mb-4 d-flex align-items-center">
                                                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                            {{ $totalPostsMonthly }}</p>
                                                        <p class="mb-0">Posts</p>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                            {{ $approvedMonthly }}</p>
                                                        <p class="mb-0">Approved</p>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <ul class="mb-0 list-unstyled">
                                                    <li class="mb-4 d-flex align-items-center">
                                                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                            {{ $pendingMonthly }}</p>
                                                        <p class="mb-0">Pending</p>
                                                    </li>
                                                    <li class="d-flex align-items-center">
                                                        <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                            {{ $rejectedMonthly }}</p>
                                                        <p class="mb-0">Rejected</p>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="order-1 my-4 text-center col-lg-5 col-md-3 col-12 order-md-2 my-md-0">
                                        <img src="../../assets/img/illustrations/card-website-analytics-1.png"
                                            alt="Post Analytics" height="150" class="card-website-analytics-img" />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-0 text-white">User Analytics</h5>
                                    <small>Total {{ $usersCount }} Users</small>
                                </div>
                                <div class="order-2 col-lg-7 col-md-9 col-12 order-md-1 pt-md-9">
                                    <h6 class="mt-0 mb-4 text-white mt-md-3">User Growth</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="mb-0 list-unstyled">
                                                <li class="mb-4 d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $usersCount }}</p>
                                                    <p class="mb-0">Total Users</p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $newUsersThisMonth }}</p>
                                                    <p class="mb-0">New Users</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="mb-0 list-unstyled">
                                                <li class="mb-4 d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $societiesCount }}</p>
                                                    <p class="mb-0">Societies</p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $totalServiceProviders }}</p>
                                                    <p class="mb-0">Service Providers</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-1 my-4 text-center col-lg-5 col-md-3 col-12 order-md-2 my-md-0">
                                    <img src="../../assets/img/illustrations/card-website-analytics-2.png"
                                        alt="User Analytics" height="150" class="card-website-analytics-img" />
                                </div>
                            </div>
                        </div>
                        <div class="swiper-slide">
                            <div class="row">
                                <div class="col-12">
                                    <h5 class="mb-0 text-white">Product Analytics</h5>
                                    <small>Total {{ $totalProducts }} Products</small>
                                </div>
                                <div class="order-2 col-lg-7 col-md-9 col-12 order-md-1 pt-md-9">
                                    <h6 class="mt-0 mb-4 text-white mt-md-3">Product Listings</h6>
                                    <div class="row">
                                        <div class="col-6">
                                            <ul class="mb-0 list-unstyled">
                                                <li class="mb-4 d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $productsNew }}</p>
                                                    <p class="mb-0">New</p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $productsUsed }}</p>
                                                    <p class="mb-0">Used</p>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-6">
                                            <ul class="mb-0 list-unstyled">
                                                <li class="mb-4 d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $totalProducts }}</p>
                                                    <p class="mb-0">Total</p>
                                                </li>
                                                <li class="d-flex align-items-center">
                                                    <p class="mb-0 fw-medium me-2 website-analytics-text-bg">
                                                        {{ $newProducts }}</p>
                                                    <p class="mb-0">New This Month</p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="order-1 my-4 text-center col-lg-5 col-md-3 col-12 order-md-2 my-md-0">
                                    <img src="../../assets/img/illustrations/card-website-analytics-3.png"
                                        alt="Product Analytics" height="150" class="card-website-analytics-img" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
            <!--/ Post Analytics -->

            <!-- Average Daily Posts -->
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="pb-0 card-header">
                        <h5 class="mb-3 card-title">Average Daily Posts</h5>
                        <p class="mb-0 text-body">Total Posts This Month</p>
                        <h4 class="mb-0">{{ number_format($totalThisMonth) }}</h4>
                        <small class="text-muted">Avg/day: {{ number_format($avgPerDay, 2) }}</small>
                    </div>
                    <div class="px-0 card-body">
                        <div id="averageDailySales"></div>
                    </div>
                </div>
            </div>
            <!--/ Average Daily Posts -->

            <!-- Users Overview -->
            <div class="col-xl-3 col-sm-6">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <p class="mb-0 text-body">Users Overview</p>
                            <p class="card-text fw-medium text-{{ $usersChangeClass }}">
                                {{ $usersChange > 0 ? '+' : '' }}{{ $usersChange }}%</p>
                        </div>
                        <h4 class="mb-1 card-title">{{ $usersCount }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-4">
                                <div class="gap-2 mb-2 d-flex align-items-center">
                                    <span class="p-1 rounded badge bg-label-info"><i
                                            class="icon-base ti tabler-inbox icon-sm"></i></span>
                                    <p class="mb-0">Posts</p>
                                </div>
                                <h5 class="pt-1 mb-0">{{ $postsPercentage }}%</h5>
                                <small class="text-body-secondary">{{ $newPosts }}</small>
                            </div>
                            <div class="col-4">
                                <div class="divider divider-vertical">
                                    <div class="divider-text">
                                        <span class="badge-divider-bg bg-label-secondary">VS</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 text-end">
                                <div class="gap-2 mb-2 d-flex justify-content-end align-items-center">
                                    <p class="mb-0">Products</p>
                                    <span class="p-1 rounded badge bg-label-primary"><i
                                            class="icon-base ti tabler-building-store icon-sm"></i></span>
                                </div>
                                <h5 class="pt-1 mb-0">{{ $productsPercentage }}%</h5>
                                <small class="text-body-secondary">{{ $newProducts }}</small>
                            </div>
                        </div>
                        <div class="mt-6 d-flex align-items-center">
                            <div class="progress w-100" style="height: 10px">
                                <div class="progress-bar bg-info" style="width: {{ $postsPercentage }}%"
                                    role="progressbar" aria-valuenow="{{ $postsPercentage }}" aria-valuemin="0"
                                    aria-valuemax="100"></div>
                                <div class="progress-bar bg-primary" role="progressbar"
                                    style="width: {{ $productsPercentage }}%" aria-valuenow="{{ $productsPercentage }}"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Users Overview -->

            <!-- Weekly Posts Reports -->
            <div class="col-md-6">
                <div class="card h-100">
                    <div class="pb-0 card-header d-flex justify-content-between">
                        <div class="mb-0 card-title">
                            <h5 class="mb-1">Weekly Posts Reports</h5>
                            <p class="card-subtitle">Weekly Posts Overview</p>
                        </div>

                    </div>
                    <div class="card-body">
                        <div class="row align-items-center g-md-8">
                            <div class="col-12 col-md-5 d-flex flex-column">
                                <div class="flex-wrap gap-2 mb-3 d-flex align-items-center">
                                    <h2 class="mb-0">{{ $totalWeeklyPosts }}</h2>
                                    <div class="rounded badge bg-label-{{ $weeklyChangeClass }}">
                                        {{ $weeklyChange > 0 ? '+' : '' }}{{ $weeklyChange }}%</div>
                                </div>
                                <small class="text-body">Posts this week compared to last week</small>
                            </div>
                            <div class="col-12 col-md-7 ps-xl-8">
                                <div id="weeklyEarningReports"></div>
                            </div>
                        </div>
                        <div class="p-5 mt-5 border rounded">
                            <div class="gap-4 row gap-sm-0">
                                <div class="col-12 col-sm-4">
                                    <div class="gap-2 d-flex align-items-center">
                                        <div class="p-1 rounded badge bg-label-primary">
                                            <i class="icon-base ti tabler-clear-all icon-18px"></i>
                                        </div>
                                        <h6 class="mb-0 fw-normal">Total Posts</h6>
                                    </div>
                                    <h4 class="my-2">{{ $totalPostsMonthly }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar" role="progressbar"
                                            style="width: {{ $postsPercentage }}%"
                                            aria-valuenow="{{ $postsPercentage }}" aria-valuemin="0"
                                            aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="gap-2 d-flex align-items-center">
                                        <div class="p-1 rounded badge bg-label-info">
                                            <i class="icon-base ti tabler-progress-check icon-18px"></i>
                                        </div>
                                        <h6 class="mb-0 fw-normal">Approved</h6>
                                    </div>
                                    <h4 class="my-2">{{ $approvedMonthly }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar bg-info" role="progressbar"
                                            style="width: {{ $approvalRate }}%" aria-valuenow="{{ $approvalRate }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                                <div class="col-12 col-sm-4">
                                    <div class="gap-2 d-flex align-items-center">
                                        <div class="p-1 rounded badge bg-label-danger">
                                            <i class="icon-base ti tabler-pennant icon-18px"></i>
                                        </div>
                                        <h6 class="mb-0 fw-normal">Pending</h6>
                                    </div>
                                    <h4 class="my-2">{{ $pendingMonthly }}</h4>
                                    <div class="progress w-75" style="height: 4px">
                                        <div class="progress-bar bg-danger" role="progressbar"
                                            style="width: {{ ($pendingMonthly / ($totalPostsMonthly ?: 1)) * 100 }}%"
                                            aria-valuenow="{{ ($pendingMonthly / ($totalPostsMonthly ?: 1)) * 100 }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Weekly Posts Reports -->

            <!-- Post Tracker -->
            <div class="col-12 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="mb-0 card-title">
                            <h5 class="mb-1">Post Tracker</h5>
                            <p class="card-subtitle">Last 7 Days</p>
                        </div>

                    </div>
                    <div class="card-body row">
                        <div class="col-12 col-sm-4">
                            <div class="mb-2 mt-lg-4 mt-lg-2 mb-lg-6">
                                <h2 class="mb-0">{{ $totalPosts }}</h2>
                                <p class="mb-0">Total Posts</p>
                            </div>
                            <ul class="p-0 m-0">
                                <li class="gap-4 pb-1 d-flex align-items-center mb-lg-3">
                                    <div class="rounded badge bg-label-primary p-1_5">
                                        <i class="icon-base ti tabler-ticket icon-md"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">New Posts</h6>
                                        <small class="text-body-secondary">{{ $newPostsThisMonth }}</small>
                                    </div>
                                </li>
                                <li class="gap-4 pb-1 d-flex align-items-center mb-lg-3">
                                    <div class="rounded badge bg-label-info p-1_5">
                                        <i class="icon-base ti tabler-circle-check icon-md"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Pending Posts</h6>
                                        <small class="text-body-secondary">{{ $pendingPosts }}</small>
                                    </div>
                                </li>
                                <li class="gap-4 pb-1 d-flex align-items-center">
                                    <div class="rounded badge bg-label-info p-1_5">
                                        <i class="icon-base ti tabler-clock icon-md"></i>
                                    </div>
                                    <div>
                                        <h6 class="mb-0 text-nowrap">Avg Response Time</h6>
                                        <small class="text-body-secondary">{{ $avgResponseTime }} Days</small>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <div class="col-12 col-md-8">
                            <div id="supportTracker"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Post Tracker -->

            <!-- Posts by Status -->
            <div class="order-1 col-xxl-4 col-md-6 order-xl-0">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="mb-0 card-title">
                            <h5 class="mb-1">Posts by Status</h5>
                            <p class="card-subtitle">Monthly Posts Overview</p>
                        </div>

                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">
                            <li class="mb-4 d-flex align-items-center">
                                <div class="flex-shrink-0 avatar me-4">
                                    <span class="avatar-initial rounded-circle bg-label-success">A</span>
                                </div>
                                <div class="flex-wrap gap-2 d-flex w-100 align-items-center justify-content-between">
                                    <div class="me-2">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ $postsByStatus['approved'] ?? 0 }}</h6>
                                        </div>
                                        <small class="text-body">Approved</small>
                                    </div>
                                    <div class="user-progress">
                                        <p
                                            class="gap-1 mb-0 text-{{ $approvedChange >= 0 ? 'success' : 'danger' }} fw-medium d-flex align-items-center">
                                            <i
                                                class="icon-base ti tabler-chevron-{{ $approvedChange >= 0 ? 'up' : 'down' }}"></i>
                                            {{ $approvedChange }}%
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-4 d-flex align-items-center">
                                <div class="flex-shrink-0 avatar me-4">
                                    <span class="avatar-initial rounded-circle bg-label-warning">P</span>
                                </div>
                                <div class="flex-wrap gap-2 d-flex w-100 align-items-center justify-content-between">
                                    <div class="me-2">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ $postsByStatus['pending'] ?? 0 }}</h6>
                                        </div>
                                        <small class="text-body">Pending</small>
                                    </div>
                                    <div class="user-progress">
                                        <p
                                            class="gap-1 mb-0 text-{{ $pendingChange >= 0 ? 'success' : 'danger' }} fw-medium d-flex align-items-center">
                                            <i
                                                class="icon-base ti tabler-chevron-{{ $pendingChange >= 0 ? 'up' : 'down' }}"></i>
                                            {{ $pendingChange }}%
                                        </p>
                                    </div>
                                </div>
                            </li>
                            <li class="mb-4 d-flex align-items-center">
                                <div class="flex-shrink-0 avatar me-4">
                                    <span class="avatar-initial rounded-circle bg-label-danger">R</span>
                                </div>
                                <div class="flex-wrap gap-2 d-flex w-100 align-items-center justify-content-between">
                                    <div class="me-2">
                                        <div class="d-flex align-items-center">
                                            <h6 class="mb-0 me-1">{{ $postsByStatus['rejected'] ?? 0 }}</h6>
                                        </div>
                                        <small class="text-body">Rejected</small>
                                    </div>
                                    <div class="user-progress">
                                        <p
                                            class="gap-1 mb-0 text-{{ $rejectedChange >= 0 ? 'success' : 'danger' }} fw-medium d-flex align-items-center">
                                            <i
                                                class="icon-base ti tabler-chevron-{{ $rejectedChange >= 0 ? 'up' : 'down' }}"></i>
                                            {{ $rejectedChange }}%
                                        </p>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Posts by Status -->

            <!-- Total Posts & Products -->
            <div class="order-2 col-12 col-md-6 col-xxl-4 order-xl-0">
                <div class="card h-100">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="mb-0 card-title">Total Posts & Products</h5>
                        </div>

                        {{-- Dynamic completion chevron (green up / red down) --}}
                        <div class="d-flex align-items-center">
                            <h2 class="mb-0 me-2">{{ $completionRate }}%</h2>

                            @php
                                $compUp = ($completionRate ?? 0) >= 0;
                            @endphp

                            <i
                                class="icon-base ti tabler-chevron-{{ $compUp ? 'up' : 'down' }} {{ $compUp ? 'text-success' : 'text-danger' }} me-1"></i>
                            <h6 class="mb-0 {{ $compUp ? 'text-success' : 'text-danger' }}">
                                {{ number_format($weeklyChangePercent ?? 0, 1) }}%
                            </h6>
                        </div>
                    </div>

                    <div class="card-body">
                        <div id="totalEarningChart"></div>

                        {{-- Total Posts --}}
                        <div class="my-4 d-flex align-items-start">
                            <div class="p-2 rounded badge bg-label-primary me-4">
                                {{-- relevant icon for posts --}}
                                <i class="icon-base ti tabler-file-text icon-md" aria-hidden="true"></i>
                            </div>

                            <div class="gap-2 d-flex justify-content-between w-100 align-items-center">
                                <div class="me-2">
                                    <h6 class="mb-0">Total Posts</h6>
                                    <small class="text-body">{{ $totalPosts }}</small>
                                </div>

                                {{-- weekly percent (safe fallback) --}}
                                @php
                                    $postPct = $weeklyChangePercent ?? 0;
                                @endphp
                                <h6 class="mb-0 {{ $postPct >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $postPct >= 0 ? '+' . $postPct : $postPct }}%
                                </h6>
                            </div>
                        </div>

                        {{-- Total Products --}}
                        <div class="d-flex align-items-start">
                            <div class="p-2 rounded badge bg-label-secondary me-4">
                                {{-- relevant icon for products --}}
                                <i class="icon-base ti tabler-box icon-md" aria-hidden="true"></i>
                            </div>

                            <div class="gap-2 d-flex justify-content-between w-100 align-items-center">
                                <div class="me-2">
                                    <h6 class="mb-0">Total Products</h6>
                                    <small class="text-body">{{ $totalProducts }}</small>
                                </div>

                                @php
                                    $prodPct = $usersChangePercent ?? 0;
                                @endphp
                                <h6 class="mb-0 {{ $prodPct >= 0 ? 'text-success' : 'text-danger' }}">
                                    {{ $prodPct >= 0 ? '+' . $prodPct : $prodPct }}%
                                </h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--/ Total Posts & Products -->


            <!-- Service Providers Overview -->
            <div class="col-xxl-4 col-md-6">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="mb-0 card-title">
                            <h5 class="mb-1">Service Providers Overview</h5>
                            <p class="card-subtitle">{{ $totalServiceProviders }} Providers</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="p-0 m-0">

                            <!-- Total -->
                            <li class="mb-6 d-flex justify-content-between align-items-center">
                                <div class="rounded badge bg-label-primary p-1_5">
                                    <i class="ti tabler-users icon-md"></i>
                                </div>
                                <div class="flex-wrap d-flex justify-content-between w-100">
                                    <h6 class="mb-0 ms-4">Total</h6>
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $totalServiceProviders }}</p>
                                        <p class="mb-0 ms-4 text-muted">All time</p>
                                    </div>
                                </div>
                            </li>

                            <!-- Approved -->
                            <li class="mb-6 d-flex justify-content-between align-items-center">
                                <div class="rounded badge bg-label-success p-1_5">
                                    <i class="ti tabler-check icon-md"></i>
                                </div>
                                <div class="flex-wrap d-flex justify-content-between w-100">
                                    <h6 class="mb-0 ms-4">Approved</h6>
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $approvedProviders }}</p>
                                        <p
                                            class="mb-0 ms-4 {{ $approvedProvidersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $approvedProvidersChange }}%
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <!-- Pending -->
                            <li class="mb-6 d-flex justify-content-between align-items-center">
                                <div class="rounded badge bg-label-warning p-1_5">
                                    <i class="ti tabler-clock icon-md"></i>
                                </div>
                                <div class="flex-wrap d-flex justify-content-between w-100">
                                    <h6 class="mb-0 ms-4">Pending</h6>
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $pendingProviders }}</p>
                                        <p
                                            class="mb-0 ms-4 {{ $pendingProvidersChange >= 0 ? 'text-success' : 'text-danger' }}">
                                            {{ $pendingProvidersChange }}%
                                        </p>
                                    </div>
                                </div>
                            </li>

                            <!-- Avg Approval Time -->
                            <li class="mb-6 d-flex justify-content-between align-items-center">
                                <div class="rounded badge bg-label-info p-1_5">
                                    <i class="ti tabler-hourglass icon-md"></i>
                                </div>
                                <div class="flex-wrap d-flex justify-content-between w-100">
                                    <h6 class="mb-0 ms-4">Avg Approval Time</h6>
                                    <div class="d-flex">
                                        <p class="mb-0">{{ $avgApprovalTime }}</p>
                                        <p class="mb-0 ms-4 text-warning">Days</p>
                                    </div>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Service Providers Overview -->



            <!-- Product Conditions -->
            <div class="col-xxl-4 col-md-6 col-12">
                <div class="card h-100">
                    <div class="card-header d-flex justify-content-between">
                        <div class="mb-0 card-title">
                            <h5 class="mb-1">Product Conditions</h5>
                            <p class="card-subtitle">{{ $totalProducts }} Products</p>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="mb-0 list-unstyled">
                            @php
                                // Map conditions to icons
                                $conditionIcons = [
                                    'new' => 'tabler-star',
                                    'like_new' => 'tabler-sparkles',
                                    'used' => 'tabler-recycle',
                                    'refurbished' => 'tabler-tool',
                                    'damaged' => 'tabler-alert-triangle',
                                    'expired' => 'tabler-calendar-x',
                                    'other' => 'tabler-dots',
                                ];

                                // Simulate percentage changes (replace later with real calc)
                                $conditionChanges = [
                                    'new' => '+4%',
                                    'like_new' => '+1%',
                                    'used' => '+2%',
                                    'refurbished' => '+3%',
                                    'damaged' => '-1%',
                                    'expired' => '-5%',
                                    'other' => '+0%',
                                ];
                            @endphp

                            @foreach ($productsByCondition as $condition => $count)
                                <li class="mb-6">
                                    <div class="d-flex align-items-center">
                                        <div class="p-2 rounded badge bg-label-secondary text-body me-4">
                                            <i
                                                class="icon-base ti {{ $conditionIcons[$condition] ?? $conditionIcons['other'] }} icon-md"></i>
                                        </div>
                                        <div class="flex-wrap gap-2 d-flex justify-content-between w-100">
                                            <div class="me-2">
                                                <h6 class="mb-0">{{ Str::headline($condition) }} Products</h6>
                                                <small class="text-body">{{ Str::headline($condition) }} condition</small>
                                            </div>
                                            <div class="d-flex align-items-center">
                                                <p class="mb-0">{{ $count }}</p>
                                                <div class="ms-4 badge bg-label-success">
                                                    {{ $conditionChanges[$condition] ?? '+0%' }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            <!--/ Product Conditions -->


        </div>
        @if ($isSuper)
            <!-- Society Related KPIs and Graphs -->
            <div class="mt-6 row g-6">

                <!-- Top 5 Societies by Members -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="mb-0 card-title">
                                <h5 class="mb-1 d-flex align-items-center">
                                    <i class="icon-base ti tabler-users icon-md me-2 text-primary"></i>
                                    Top 5 Societies by Members
                                </h5>
                                <p class="card-subtitle text-muted">
                                    <i class="icon-base ti tabler-chart-bar icon-md me-1 text-secondary"></i>
                                    Avg Members/Society: {{ $avgMembersPerSociety }}
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="topSocietiesMembersChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Top 5 Societies by Products -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="mb-0 card-title">
                                <h5 class="mb-1 d-flex align-items-center">
                                    <i class="icon-base ti tabler-box-seam icon-md me-2 text-success"></i>
                                    Top 5 Societies by Products
                                </h5>
                                <p class="card-subtitle text-muted">
                                    <i class="icon-base ti tabler-package icon-md me-1 text-secondary"></i>
                                    Avg Products/Society: {{ $avgProductsPerSociety }}
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="topSocietiesProductsChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Top 5 Societies by Providers -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <div class="mb-0 card-title">
                                <h5 class="mb-1 d-flex align-items-center">
                                    <i class="icon-base ti tabler-building-store icon-md me-2 text-warning"></i>
                                    Top 5 Societies by Providers
                                </h5>
                                <p class="card-subtitle text-muted">
                                    <i class="icon-base ti tabler-briefcase icon-md me-1 text-secondary"></i>
                                    Avg Providers/Society: {{ $avgProvidersPerSociety }}
                                </p>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="topSocietiesProvidersChart"></div>
                        </div>
                    </div>
                </div>

                <!-- Bottom 5 Societies by Members -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header">
                            <h5 class="mb-1 d-flex align-items-center">
                                <i class="icon-base ti tabler-arrow-down-right icon-md me-2 text-danger"></i>
                                Bottom 5 Societies by Members
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @foreach ($bottomSocietiesMembers as $society)
                                    <li class="pb-1 mb-2 d-flex justify-content-between border-bottom">
                                        <span>
                                            <i class="icon-base ti tabler-home icon-md me-2 text-muted"></i>
                                            {{ $society->name }}
                                        </span>
                                        <span class="fw-medium">{{ $society->users_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Top 5 Societies by Products (List) -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header">
                            <h5 class="mb-1 d-flex align-items-center">
                                <i class="icon-base ti tabler-cube icon-md me-2 text-success"></i>
                                Top 5 Societies by Products (List)
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @foreach ($topSocietiesProducts as $society)
                                    <li class="pb-1 mb-2 d-flex justify-content-between border-bottom">
                                        <span>
                                            <i class="icon-base ti tabler-building icon-md me-2 text-muted"></i>
                                            {{ $society->name }}
                                        </span>
                                        <span class="fw-medium">{{ $society->products_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Top 5 Societies by Providers (List) -->
                <div class="col-xl-4 col-md-6">
                    <div class="border-0 shadow-sm card h-100">
                        <div class="card-header">
                            <h5 class="mb-1 d-flex align-items-center">
                                <i class="icon-base ti tabler-heart-handshake icon-md me-2 text-info"></i>
                                Top 5 Societies by Providers (List)
                            </h5>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled">
                                @foreach ($topSocietiesProviders as $society)
                                    <li class="pb-1 mb-2 d-flex justify-content-between border-bottom">
                                        <span>
                                            <i class="icon-base ti tabler-building-community icon-md me-2 text-muted"></i>
                                            {{ $society->name }}
                                        </span>
                                        <span class="fw-medium">{{ $society->service_providers_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        @endif


    </div>

@endsection
@section('vendor-js')

@endsection
@section('page-js')
    {{-- <script src="{{ asset('assets/js/dashboards-analytics.js') }}"></script> --}}
    @include('admin.dashboard.script')
@endsection
