@extends('frontend.layouts.app')
@section('title', 'Posts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">
    <style>
        /* small visual tweaks */
        .post-card {
            border-radius: .5rem;
            transition: box-shadow .3s ease;
        }

        .post-card:hover {
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .post-card .card-body {
            min-height: 220px;
        }

        .post-card .excerpt {
            color: #6c757d;
        }

        .post-card .card-footer {
            padding: .75rem 1rem;
        }

        .kpi-card {
            min-height: 92px;
            border-radius: .5rem;
            padding: 1rem;
        }

        .bg-label-primary {
            background-color: #f0f9ff !important;
        }
    </style>
@endsection

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
                    <li class="breadcrumb-item active text-dark" aria-current="page">Posts</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            {{-- Main content --}}
            <div class="col-lg-10">

                {{-- KPI + Add --}}
                <div class="mb-4 card">
                    <div class="gap-3 card-body d-flex flex-column flex-md-row align-items-start">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">Society Posts</h4>
                            <p class="mb-0 text-muted">Browse posts from your society</p>
                        </div>
                        <div class="gap-2 d-flex align-items-center">
                            <div class="text-center shadow-sm kpi-card">
                                <div class="small text-muted">Total posts</div>
                                <div class="mb-0 display-6 fw-bold">{{ number_format($approvedCount ?? 0) }}</div>
                            </div>
                            <div class="ms-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                    <i class="menu-icon icon-base ti tabler-plus me-1"></i> Add Post
                                </button>
                                @include('frontend.posts.partials.create-post')
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Filters --}}
                <div class="p-3 mb-4 card">
                    <form id="postsFilterForm" class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="search" name="q" id="q"
                                placeholder="Search posts, titles, content..." class="form-control form-control-sm" />
                        </div>
                        <div class="col-md-3">
                            <select name="category" id="categoryFilter" class="form-select form-select-sm">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="gap-2 col-md-3 d-flex">
                            <select name="sort" id="sortFilter" class="form-select form-select-sm">
                                <option value="latest">Latest</option>
                                <option value="oldest">Oldest</option>
                                <option value="most_viewed">Most viewed</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
                        </div>
                    </form>
                </div>

                {{-- Posts grid + pagination (AJAX target) --}}
                <div id="postsContainer">
                    @include('frontend.posts.partials.posts-grid', ['posts' => $posts])
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-2">
                <div class="position-sticky" style="top: 95px;">

                    {{-- Recent posts --}}
                    <div class="mb-3 card">
                        <div class="card-body">
                            <h6 class="mb-3">Recent Posts</h6>
                            <ul class="mb-0 list-unstyled">
                                @foreach ($recentPosts as $r)
                                    <li class="mb-2 d-flex align-items-start">
                                        <a href="{{ route('posts.show', $r->id) }}"
                                            class="text-decoration-none flex-grow-1">
                                            <strong class="d-block">{{ Str::limit($r->title, 60) }}</strong>
                                            <small class="text-muted">{{ $r->created_at->format('M j, Y') }}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- CTA --}}
                    <div class="shadow-sm card">
                        <div class="text-center card-body">
                            <h6 class="mb-2">Share something new</h6>
                            <p class="mb-3 small text-muted">Have news or an update? Create a post for your society.</p>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                <i class="menu-icon icon-base ti tabler-edit me-1"></i> Create Post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')
    <script src="{{ asset('assets/js/app-academy-course.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = $('#postsFilterForm');
            const container = $('#postsContainer');

            form.on('submit', e => {
                e.preventDefault();
                fetchPosts(form.serialize());
            });

            container.on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'), window.location.origin);
                fetchPosts(url.searchParams.toString());
            });

            function fetchPosts(params) {
                $.ajax({
                    url: '{{ route('posts.index') }}',
                    data: params,
                    beforeSend() {
                        container.fadeTo(200, .5);
                    },
                    success(html) {
                        container.html(html);
                    },
                    complete() {
                        container.fadeTo(200, 1);
                    }
                });
            }
        });
    </script>
@endsection
