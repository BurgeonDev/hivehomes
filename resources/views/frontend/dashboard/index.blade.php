@extends('frontend.layouts.app')
@section('title', 'Dashboard')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/highlight/highlight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
@endsection
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
                            <div class="d-flex align-items-center flex-column">

                                @if (!empty($user->profile_pic))
                                    <img src="{{ asset('storage/' . $user->profile_pic) }}" alt="{{ $user->name }}"
                                        class="rounded-circle" style="width:60px; height:60px; object-fit:cover;">
                                @else
                                    <span
                                        class="avatar-initial rounded-circle bg-label-primary d-flex align-items-center justify-content-center"
                                        style="width:60px; height:60px; font-size:20px;">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </span>
                                @endif


                                <div class="mt-2 text-center user-info">
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
                                            class="badge {{ ($user->is_active ?? 'Active') === 'Active' ? 'bg-label-success' : 'bg-label-danger' }}">
                                            {{ $user->is_active ?? 'Active' }}
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

                                            {{-- ====== SERVICES BY USER SECTION ====== --}}
                                            <div>
                                                <div class="mb-3 d-flex align-items-center justify-content-between">
                                                    <div class="d-flex align-items-center">
                                                        <div class="p-2 text-white me-3 rounded-circle bg-label-secondary d-flex align-items-center justify-content-center"
                                                            style="width:44px;height:44px;">
                                                            <i class="icon-base ti tabler-briefcase"></i>
                                                        </div>
                                                        <div>
                                                            <h5 class="mb-0">Services by You</h5>
                                                            <small class="text-muted">Overview of services you’ve
                                                                added</small>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a href="{{ route('service-providers.index') }}"
                                                            class="btn btn-sm btn-outline-secondary">View Service
                                                            Providers</a>
                                                    </div>
                                                </div>

                                                <div class="row gy-3">
                                                    {{-- Total Services Added --}}
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-primary">
                                                                <i class="icon-base ti tabler-plus icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">{{ $user->serviceProviders->count() }}
                                                                </h5>
                                                                <small class="text-muted">Total Added</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Approved Services --}}
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-success">
                                                                <i class="icon-base ti tabler-check icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">
                                                                    {{ $user->serviceProviders()->where('is_approved', true)->count() }}
                                                                </h5>
                                                                <small class="text-muted">Approved</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Pending Services --}}
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-warning">
                                                                <i class="icon-base ti tabler-clock icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">
                                                                    {{ $user->serviceProviders()->where('is_approved', false)->count() }}
                                                                </h5>
                                                                <small class="text-muted">Pending</small>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    {{-- Reviews on User’s Services --}}
                                                    <div class="col-md-3 col-6">
                                                        <div
                                                            class="p-3 bg-white shadow-sm d-flex align-items-center rounded-3">
                                                            <div class="p-2 rounded me-3 badge bg-label-info">
                                                                <i class="icon-base ti tabler-star icon-lg"></i>
                                                            </div>
                                                            <div class="card-info">
                                                                <h5 class="mb-0">
                                                                    {{ \App\Models\ServiceProviderReview::whereIn(
                                                                        'service_provider_id',
                                                                        $user->serviceProviders->pluck('id'),
                                                                    )->count() }}
                                                                </h5>
                                                                <small class="text-muted">Total Reviews</small>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                        </div> <!-- w-100 -->
                                    </div> <!-- card-body -->
                                </div> <!-- card -->
                            </div> <!-- col -->
                        </div> <!-- tab -->



                        {{-- PRODUCTS --}}
                        <div id="tab-products" class="tab-pane fade">
                            <div class="mb-4 card">
                                <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                                    {{-- Title --}}
                                    <div class="col-md-auto me-auto">
                                        <h5 class="mb-0 card-title">Products</h5>
                                    </div>

                                    {{-- Export + Add Buttons --}}
                                    <div class="col-md-auto ms-auto">
                                        <div class="flex-wrap mb-0 dt-buttons btn-group">
                                            {{-- Export Dropdown --}}
                                            <!-- Products Tab -->
                                            <div class="btn-group">
                                                <button
                                                    class="btn buttons-collection btn-label-primary dropdown-toggle me-4"
                                                    type="button" id="products-exportDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="gap-2 d-flex align-items-center">
                                                        <i class="icon-base ti tabler-upload icon-xs me-sm-1"></i>
                                                        <span class="d-none d-sm-inline-block">Export</span>
                                                    </span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="products-exportDropdown">
                                                    <li><a class="dropdown-item" href="#"
                                                            id="products-export-csv">CSV</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="products-export-excel">Excel</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="products-export-pdf">PDF</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="products-export-print">Print</a></li>
                                                </ul>
                                            </div>


                                            {{-- <button class="btn create-new btn-primary" data-bs-toggle="offcanvas"
                                            data-bs-target="#offcanvasProduct" aria-controls="offcanvasProduct"
                                            id="btnAddProduct" type="button">
                                            <span class="gap-2 d-flex align-items-center">
                                                <i class="icon-base ti tabler-plus icon-sm"></i>
                                                <span class="d-none d-sm-inline-block">Add Product</span>
                                            </span>
                                        </button> --}}
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if ($products->count())
                                        <div class="p-3 card-datatable table-responsive">
                                            <table class="table datatables-basic products-table">
                                                <thead>
                                                    <tr>
                                                        <th>#</th>
                                                        <th>Title</th>
                                                        <th>Description</th>
                                                        <th>Category</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Status</th>
                                                        <th>Views</th>
                                                        <th>Added</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($products as $index => $product)
                                                        <tr>
                                                            <td>{{ $index + 1 }}</td>
                                                            <td>{{ $product->title }}</td>
                                                            <td>{{ Str::limit($product->description, 50) }}</td>
                                                            <td>{{ $product->category->name ?? 'N/A' }}</td>
                                                            <td>{{ number_format($product->price, 2) }}</td>
                                                            <td>{{ $product->quantity }}</td>
                                                            <td>
                                                                <span
                                                                    class="badge
                                            @if ($product->status == 'approved') bg-success
                                            @elseif($product->status == 'pending') bg-warning
                                            @else bg-danger @endif">
                                                                    {{ ucfirst($product->status) }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $product->views }}</td>
                                                            <td>{{ $product->created_at->diffForHumans() }}</td>
                                                            <td class="text-center">
                                                                {{-- View --}}
                                                                <a href="{{ route('products.show', $product) }}"
                                                                    class="btn btn-icon " title="View">
                                                                    <i class="ti tabler-eye text-info"></i>
                                                                </a>

                                                                {{-- Edit --}}
                                                                @php
                                                                    $productPayload = [
                                                                        'id' => $product->id,
                                                                        'title' => $product->title,
                                                                        'description' => $product->description,
                                                                        'category_id' => $product->category_id,
                                                                        'price' => $product->price,
                                                                        'quantity' => $product->quantity,
                                                                        'condition' => $product->condition,
                                                                        'is_negotiable' =>
                                                                            (int) $product->is_negotiable,
                                                                        'is_featured' => (int) $product->is_featured,
                                                                        'society_id' => $product->society_id,
                                                                        'society_name' => optional($product->society)
                                                                            ->name,
                                                                        'images' => $product->images->map(
                                                                            fn($img) => [
                                                                                'id' => $img->id,
                                                                                'url' => asset('storage/' . $img->path),
                                                                            ],
                                                                        ),
                                                                    ];
                                                                @endphp
                                                                <button
                                                                    class="btn btn-icon text-warning btn-open-edit-product"
                                                                    type="button"
                                                                    data-product='@json($productPayload)'>
                                                                    <i class="ti tabler-pencil text-warning"></i>
                                                                </button>


                                                                {{-- Delete --}}
                                                                <form action="{{ route('products.destroy', $product) }}"
                                                                    method="POST" class="d-inline delete-form">
                                                                    @csrf
                                                                    @method('DELETE')
                                                                    <button type="submit"
                                                                        class="btn btn-icon text-danger show-confirm"
                                                                        title="Delete">
                                                                        <i class="ti tabler-trash"></i>
                                                                    </button>
                                                                </form>
                                                            </td>

                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
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
                        @include('frontend.products.partials.product-modal')

                        {{-- POSTS --}}
                        <div id="tab-posts" class="tab-pane fade">
                            <div class="mb-4 card">
                                <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                                    {{-- Title --}}
                                    <div class="col-md-auto me-auto">
                                        <h5 class="mb-0 card-title">Posts</h5>
                                    </div>

                                    {{-- Export + Add Buttons --}}
                                    <div class="col-md-auto ms-auto">
                                        <div class="flex-wrap mb-0 dt-buttons btn-group">
                                            <!-- Posts Tab -->
                                            <div class="btn-group">
                                                <button
                                                    class="btn buttons-collection btn-label-primary dropdown-toggle me-4"
                                                    type="button" id="posts-exportDropdown" data-bs-toggle="dropdown"
                                                    aria-expanded="false">
                                                    <span class="gap-2 d-flex align-items-center">
                                                        <i class="icon-base ti tabler-upload icon-xs me-sm-1"></i>
                                                        <span class="d-none d-sm-inline-block">Export</span>
                                                    </span>
                                                </button>
                                                <ul class="dropdown-menu" aria-labelledby="posts-exportDropdown">
                                                    <li><a class="dropdown-item" href="#"
                                                            id="posts-export-csv">CSV</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="posts-export-excel">Excel</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="posts-export-pdf">PDF</a></li>
                                                    <li><a class="dropdown-item" href="#"
                                                            id="posts-export-print">Print</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="card-body">
                                    @if ($posts->count())
                                        <div class="p-3 card-datatable table-responsive">
                                            <table class="table datatables-basic posts-table">
                                                <thead>
                                                    <tr>
                                                        <th>Title</th>
                                                        <th>Status</th>
                                                        <th>Created</th>
                                                        <th>Content</th>
                                                        <th>Comments</th>
                                                        <th>Likes</th>
                                                        <th>Views</th>
                                                        <th>Author</th>
                                                        <th>Actions</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach ($posts as $post)
                                                        <tr>
                                                            {{-- Title --}}
                                                            <td class="fw-bold text-truncate" style="max-width:180px;"
                                                                title="{{ $post->title }}">
                                                                {{ $post->title }}
                                                            </td>

                                                            {{-- Status --}}
                                                            <td>
                                                                <span
                                                                    class="badge
                                            @if ($post->status == 'approved') bg-label-success
                                            @elseif($post->status == 'pending') bg-label-warning
                                            @else bg-label-danger @endif">
                                                                    {{ ucfirst($post->status ?? 'N/A') }}
                                                                </span>
                                                            </td>

                                                            {{-- Created Date --}}
                                                            <td>
                                                                <small class="text-muted">
                                                                    <i class="icon-base ti tabler-calendar-time me-1"></i>
                                                                    {{ $post->created_at->diffForHumans() }}
                                                                </small>
                                                            </td>

                                                            {{-- Content Preview --}}
                                                            <td style="max-width:250px;">
                                                                <small class="text-muted">
                                                                    {!! Str::limit($post->body ?? '<em>No content</em>', 80) !!}
                                                                </small>
                                                            </td>

                                                            {{-- Comments --}}
                                                            <td>
                                                                <span class="badge bg-label-primary">
                                                                    <i class="icon-base ti tabler-message-circle me-1"></i>
                                                                    {{ $post->comments->count() ?? 0 }}
                                                                </span>
                                                            </td>

                                                            {{-- Likes --}}
                                                            <td>
                                                                <span class="badge bg-label-danger">
                                                                    <i class="icon-base ti tabler-heart me-1"></i>
                                                                    {{ $post->likes_count ?? $post->likedByUsers->count() }}
                                                                </span>
                                                            </td>

                                                            {{-- Views --}}
                                                            <td>
                                                                <small class="text-muted">
                                                                    <i
                                                                        class="icon-base ti tabler-eye me-1"></i>{{ $post->views ?? 0 }}
                                                                </small>
                                                            </td>

                                                            {{-- Author --}}
                                                            <td>
                                                                <small class="text-muted">
                                                                    {{ $post->author->name ?? ($post->user->name ?? 'You') }}
                                                                </small>
                                                            </td>

                                                            {{-- Actions --}}
                                                            <td>
                                                                <div class="gap-2 d-flex">
                                                                    {{-- Read --}}
                                                                    <a href="{{ route('posts.show', $post) }}"
                                                                        class="btn btn-icon" title="View">
                                                                        <i class="ti tabler-eye text-info"></i>
                                                                    </a>

                                                                    {{-- Edit --}}
                                                                    <button class="btn btn-icon" data-bs-toggle="modal"
                                                                        data-bs-target="#editPostModal-{{ $post->id }}"
                                                                        title="Edit">
                                                                        <i class="ti tabler-pencil text-warning"></i>
                                                                    </button>

                                                                    {{-- Delete --}}
                                                                    <form action="{{ route('posts.destroy', $post->id) }}"
                                                                        method="POST" class="d-inline delete-form">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <button type="submit"
                                                                            class="btn btn-icon text-danger show-confirm"
                                                                            title="Delete">
                                                                            <i class="ti tabler-trash"></i>
                                                                        </button>
                                                                    </form>
                                                                </div>
                                                            </td>

                                                        </tr>

                                                        {{-- Include Edit Modal --}}
                                                        @include('frontend.posts.partials.edit-post', [
                                                            'post' => $post,
                                                        ])
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>

                                        {{-- Pagination --}}
                                        <div class="mt-3">
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
                                                                    class="icon-base ti tabler-star{{ $i <= $review->rating ? '' : '-off' }}">
                                                                </i>
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
@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    {{-- <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script> --}}
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/highlight/highlight.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/js/app-academy-course.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
@endsection
@section('page-js')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
            let pond = FilePond.create(document.querySelector('#product-images'), {
                allowMultiple: true,
                acceptedFileTypes: ['image/*'],
                storeAsFile: true,
                credits: false
            });

            const removedInputContainer = document.getElementById(
                'existing-images'); // Use existing-images as container
            let removedIds = [];

            function renderExistingImages(images = []) {
                const container = document.getElementById('existing-images');
                container.innerHTML = '';
                removedIds = [];

                // Clear previous hidden inputs
                document.querySelectorAll('input[name="delete_images[]"]').forEach(input => input.remove());

                images.forEach(img => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');
                    wrapper.innerHTML = `
                <img src="${img.url}" width="100" class="rounded">
                <button type="button" class="top-0 btn btn-sm btn-danger position-absolute end-0 btn-remove-existing" data-id="${img.id}">&times;</button>
            `;
                    container.appendChild(wrapper);
                });
            }

            // Remove existing image click
            document.addEventListener('click', e => {
                if (e.target.classList.contains('btn-remove-existing')) {
                    const id = e.target.dataset.id;
                    removedIds.push(id);

                    // Create a hidden input for each removed ID
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'delete_images[]';
                    hiddenInput.value = id;
                    removedInputContainer.appendChild(hiddenInput);

                    e.target.closest('div').remove();
                }
            });


            // Edit Product
            document.addEventListener('click', e => {
                if (e.target.closest('.btn-open-edit-product')) {
                    const product = JSON.parse(e.target.closest('.btn-open-edit-product').dataset.product);

                    document.getElementById('productId').value = product.id;
                    document.getElementById('prod-title').value = product.title;
                    document.getElementById('prod-category').value = product.category_id;
                    document.getElementById('prod-price').value = product.price;
                    document.getElementById('prod-quantity').value = product.quantity;
                    document.getElementById('prod-condition').value = product.condition;
                    document.getElementById('prod-description').value = product.description;

                    // ✅ society select only if exists (super admin)
                    const societySelect = document.getElementById('prod-society');
                    if (societySelect) {
                        societySelect.value = product.society_id;
                    }

                    renderExistingImages(product.images ?? []);
                    pond.removeFiles();

                    document.getElementById('productFormMethod').value = 'PUT';
                    document.getElementById('productModalTitle').innerText = 'Edit Product';
                    document.getElementById('productForm').action = "/products/" + product.id;

                    new bootstrap.Modal(document.getElementById('productModal')).show();
                }
            });


        });
    </script>
    <script>
        $(document).ready(function() {
            // Initialize Products DataTable
            const productsTable = $('.products-table').DataTable({
                responsive: true,
                lengthChange: true,
                order: [
                    [1, 'asc']
                ],
                layout: {
                    topStart: {
                        rowClass: 'row mx-3 my-0 justify-content-between',
                        features: [{
                            pageLength: {
                                menu: [7, 10, 25, 50, 100],
                                text: 'Show _MENU_ entries'
                            }
                        }]
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Search...'
                        }
                    },
                    bottomStart: {
                        rowClass: 'row mx-3 justify-content-between',
                        features: ['info']
                    },
                    bottomEnd: 'paging'
                },
                displayLength: 7,
                language: {
                    paginate: {
                        next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                        previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                        first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                        last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                    }
                },
                buttons: [{
                        extend: 'csv',
                        title: 'Products',
                        filename: 'Products_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)', // exclude Actions column
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Products',
                        filename: 'Products_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Products',
                        filename: 'Products_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Products',
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    }
                ]
            });

            // Initialize Posts DataTable
            const postsTable = $('.posts-table').DataTable({
                responsive: true,
                lengthChange: true,
                order: [
                    [1, 'asc']
                ],
                layout: {
                    topStart: {
                        rowClass: 'row mx-3 my-0 justify-content-between',
                        features: [{
                            pageLength: {
                                menu: [7, 10, 25, 50, 100],
                                text: 'Show _MENU_ entries'
                            }
                        }]
                    },
                    topEnd: {
                        search: {
                            placeholder: 'Search...'
                        }
                    },
                    bottomStart: {
                        rowClass: 'row mx-3 justify-content-between',
                        features: ['info']
                    },
                    bottomEnd: 'paging'
                },
                displayLength: 7,
                language: {
                    paginate: {
                        next: '<i class="icon-base ti tabler-chevron-right scaleX-n1-rtl icon-18px"></i>',
                        previous: '<i class="icon-base ti tabler-chevron-left scaleX-n1-rtl icon-18px"></i>',
                        first: '<i class="icon-base ti tabler-chevrons-left scaleX-n1-rtl icon-18px"></i>',
                        last: '<i class="icon-base ti tabler-chevrons-right scaleX-n1-rtl icon-18px"></i>'
                    }
                },
                buttons: [{
                        extend: 'csv',
                        title: 'Posts',
                        filename: 'Posts_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)', // exclude Actions column
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'excel',
                        title: 'Posts',
                        filename: 'Posts_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'pdf',
                        title: 'Posts',
                        filename: 'Posts_' + new Date().toISOString().slice(0, 10),
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    },
                    {
                        extend: 'print',
                        title: 'Posts',
                        className: 'd-none',
                        exportOptions: {
                            columns: ':not(:last-child)',
                            format: {
                                body: exportFormatter
                            }
                        }
                    }
                ]
            });

            // Export triggers for Products
            $('#products-export-csv').on('click', e => {
                e.preventDefault();
                productsTable.button(0).trigger();
            });
            $('#products-export-excel').on('click', e => {
                e.preventDefault();
                productsTable.button(1).trigger();
            });
            $('#products-export-pdf').on('click', e => {
                e.preventDefault();
                productsTable.button(2).trigger();
            });
            $('#products-export-print').on('click', e => {
                e.preventDefault();
                productsTable.button(3).trigger();
            });

            // Export triggers for Posts
            $('#posts-export-csv').on('click', e => {
                e.preventDefault();
                postsTable.button(0).trigger();
            });
            $('#posts-export-excel').on('click', e => {
                e.preventDefault();
                postsTable.button(1).trigger();
            });
            $('#posts-export-pdf').on('click', e => {
                e.preventDefault();
                postsTable.button(2).trigger();
            });
            $('#posts-export-print').on('click', e => {
                e.preventDefault();
                postsTable.button(3).trigger();
            });

            // Universal formatter for export
            function exportFormatter(data, row, column, node) {
                const $node = $(node);

                // If checkbox
                const $checkbox = $node.find('input[type="checkbox"]');
                if ($checkbox.length) {
                    return $checkbox.prop('checked') ? 'Active' : 'Inactive';
                }

                // If select/dropdown
                const $select = $node.find('select');
                if ($select.length) {
                    return $select.find('option:selected').text().trim();
                }

                // Otherwise plain text (remove HTML)
                return $node.text().trim();
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.show-confirm').forEach(button => {
                button.addEventListener('click', function(e) {
                    e.preventDefault();

                    const form = this.closest('.delete-form');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    });
                });
            });
        });
    </script>
@endsection
