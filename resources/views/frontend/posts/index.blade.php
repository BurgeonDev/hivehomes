@extends('frontend.layouts.app')
@section('title', 'Posts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">
    <style>
        /* small visual tweaks */
        .post-card .card-body {
            min-height: 220px;
        }

        .post-card .excerpt {
            color: #586069;
        }

        .post-meta * {
            font-size: 0.9rem;
        }

        .post-img {
            transition: transform .25s ease;
        }

        .post-card:hover .post-img {
            transform: scale(1.03);
        }

        .kpi-card {
            min-height: 92px;
        }

        .author-chip {
            font-size: .85rem;
        }
    </style>
@endsection

@section('content')
    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 240px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">

        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-decoration-none text-primary">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Posts</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Top KPIs & Actions --}}
                <div class="mb-4 card">
                    <div class="gap-3 card-body d-flex flex-column flex-md-row align-items-start">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">Society Posts</h4>
                            <p class="mb-0 text-muted">Browse, manage and review posts from your society</p>
                        </div>

                        <div class="gap-2 d-flex align-items-center">
                            <div class="gap-2 d-flex">
                                <div class="p-2 text-center shadow-sm card kpi-card">
                                    <div class="small text-muted">Approved</div>
                                    <div class="mb-0 h5">{{ number_format($approvedCount ?? 0) }}</div>
                                </div>

                                <div class="p-2 text-center shadow-sm card kpi-card">
                                    <div class="small text-muted">Pending</div>
                                    <div class="mb-0 h5">{{ number_format($pendingCount ?? 0) }}</div>
                                </div>
                            </div>

                            <div class="ms-2">
                                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createPostModal">
                                    <i class="ti ti-plus me-1"></i> Add Post
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
                            <input type="search" name="q" value="{{ request('q') }}"
                                placeholder="Search posts, titles, content..." class="form-control form-control-sm" />
                        </div>

                        <div class="col-md-3">
                            <select name="category" id="categoryFilter" class="form-select form-select-sm">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="gap-2 col-md-3 d-flex">
                            <select name="sort" class="form-select form-select-sm">
                                <option value="latest" {{ request('sort') == 'latest' ? 'selected' : '' }}>Latest</option>
                                <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="most_viewed" {{ request('sort') == 'most_viewed' ? 'selected' : '' }}>Most
                                    viewed</option>
                            </select>
                            <button type="submit" class="btn btn-sm btn-outline-primary">Filter</button>
                        </div>
                    </form>
                </div>

                {{-- Posts grid --}}
                <div class="row gy-4">
                    @forelse($posts as $post)
                        @php
                            $plain = strip_tags($post->body ?? '');
                            $words = str_word_count($plain);
                            $readMinutes = max(1, (int) ceil($words / 200));
                            $commentsCount = $post->comments()->count();
                        @endphp

                        <div class="col-sm-6">
                            <article class="shadow-sm card post-card h-100">
                                <div class="row g-0">
                                    <div class="col-5">
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="overflow-hidden d-block rounded-start">
                                            @if ($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                                    class="img-fluid post-img w-100 h-100 object-fit-cover"
                                                    style="height:180px;">
                                            @else
                                                <img src="{{ asset('assets/img/pages/app-academy-tutor-1.png') }}"
                                                    alt="placeholder"
                                                    class="img-fluid post-img w-100 h-100 object-fit-cover"
                                                    style="height:180px;">
                                            @endif
                                        </a>
                                    </div>

                                    <div class="col-7">
                                        <div class="card-body d-flex flex-column">
                                            <div class="mb-2 d-flex align-items-start">
                                                @if ($post->category)
                                                    <span
                                                        class="badge bg-label-primary text-capitalize me-2">{{ $post->category->name }}</span>
                                                @endif
                                                <small
                                                    class="text-muted ms-auto">{{ $post->created_at->format('M j, Y') }}</small>
                                            </div>

                                            <h5 class="mb-1 h6">
                                                <a href="{{ route('posts.show', $post->id) }}"
                                                    class="text-decoration-none text-dark">
                                                    {{ \Illuminate\Support\Str::limit($post->title, 78) }}
                                                </a>
                                            </h5>

                                            <p class="mb-2 excerpt">
                                                {{ \Illuminate\Support\Str::limit(strip_tags($post->body), 120) }}</p>

                                            <div class="gap-2 mt-auto d-flex align-items-center post-meta">
                                                {{-- author chip --}}
                                                <div class="d-flex align-items-center author-chip">
                                                    @if (!empty($post->user->profile_pic))
                                                        <img src="{{ asset('storage/' . $post->user->profile_pic) }}"
                                                            class="rounded-circle me-2" width="28" height="28"
                                                            style="object-fit:cover;">
                                                    @else
                                                        <div class="text-white rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                                                            style="width:28px;height:28px;font-size:.85rem;">
                                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                                        </div>
                                                    @endif
                                                    <small class="text-muted">{{ $post->user->name }}</small>
                                                </div>

                                                {{-- read time --}}
                                                <small class="text-muted ms-2">{{ $readMinutes }} min read</small>

                                                {{-- views/comments --}}
                                                <small class="text-muted ms-2"><i class="ti ti-eye me-1"></i>
                                                    {{ number_format($post->views ?? 0) }}</small>
                                                <small class="text-muted ms-2"><i class="ti ti-message-circle me-1"></i>
                                                    {{ $commentsCount }}</small>

                                                <div class="ms-auto">
                                                    <a href="{{ route('posts.show', $post->id) }}"
                                                        class="btn btn-sm btn-label-primary">View</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        </div>
                    @empty
                        <div class="col-12">
                            <div class="shadow-sm card">
                                <div class="py-5 text-center card-body">
                                    <h5 class="mb-1">No posts found</h5>
                                    <p class="mb-3 text-muted">There are no posts to show right now.</p>
                                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">Reset
                                        filters</a>
                                </div>
                            </div>
                        </div>
                    @endforelse
                </div>

                {{-- Pagination --}}
                <div class="mt-4 d-flex justify-content-center">
                    {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 95px;">
                    {{-- Quick filters summary --}}
                    <div class="mb-3 card">
                        <div class="card-body">
                            <h6 class="mb-2">Quick Filters</h6>
                            <p class="mb-2 small text-muted">Jump to commonly used filters</p>
                            <div class="gap-2 d-grid">
                                <a href="{{ route('posts.index') }}" class="btn btn-sm btn-outline-secondary">All
                                    posts</a>
                                <a href="{{ route('posts.index', ['filter' => 'approved']) }}"
                                    class="btn btn-sm btn-outline-success">Approved</a>
                                <a href="{{ route('posts.index', ['filter' => 'pending']) }}"
                                    class="btn btn-sm btn-outline-danger">Pending</a>
                            </div>
                        </div>
                    </div>

                    {{-- Recent posts (compact) --}}
                    <div class="mb-3 card">
                        <div class="card-body">
                            <h6 class="mb-3">Recent Posts</h6>
                            <ul class="mb-0 list-unstyled">
                                @foreach (\App\Models\Post::latest()->take(6)->get() as $r)
                                    <li class="mb-2 d-flex align-items-start">
                                        <a href="{{ route('posts.show', $r->id) }}"
                                            class="text-decoration-none flex-grow-1">
                                            <strong
                                                class="d-block">{{ \Illuminate\Support\Str::limit($r->title, 60) }}</strong>
                                            <small class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- CTA: create post for users --}}
                    <div class="shadow-sm card">
                        <div class="text-center card-body">
                            <h6 class="mb-2">Share something new</h6>
                            <p class="mb-3 small text-muted">Have news or an update? Create a post for your society.</p>
                            <button class="btn btn-primary w-100" data-bs-toggle="modal"
                                data-bs-target="#createPostModal">
                                <i class="ti ti-edit me-1"></i> Create Post
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
        document.addEventListener('DOMContentLoaded', function() {
            // submit filter on Enter
            const form = document.getElementById('postsFilterForm');
            // progressive enhancement: submit on category change
            const category = document.getElementById('categoryFilter');
            category && category.addEventListener('change', () => form.submit());
        });
    </script>
@endsection
