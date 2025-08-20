@extends('frontend.layouts.app')
@section('title', 'Posts')
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">
@endsection
@section('content')
    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 300px;">
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
        <div class="app-academy">

            <div class="mb-6 card">
                <div class="flex-wrap gap-4 card-header d-flex justify-content-between">
                    <div class="mb-0 card-title me-1">
                        <h5 class="mb-0">Society Posts</h5>
                        <p class="mb-0">Total {{ $approvedCount }} approved posts</p>
                    </div>
                    <div
                        class="row-gap-4 mb-3 d-flex flex-column flex-sm-row justify-content-md-end align-items-center column-gap-6">
                        {{-- Category Filter --}}
                        <select class="form-select" name="category" id="categoryFilter">
                            <option value="">All Categories</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>

                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#createPostModal">
                            <i class="ti ti-plus"></i> Add Post
                        </button>
                        @include('frontend.posts.partials.create-post')

                        {{-- @auth
                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('society_admin'))
                                <div class="col-lg-6">
                                    <div class="p-4 border
                        {{-- @auth
                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('society_admin'))
                                <div class="col-lg-6">
                                    <div class="p-4 border rounded d-flex align-items-center border-danger h-100">
                                        <i class="icon-base ti tabler-clock icon-2x text-danger me-4"></i>
                                        <div class="flex-grow-1">
                                            <h5 class="mb-1 text-danger">Pending Posts</h5>
                                            <p class="mb-2 text-body-secondary">{{ $pendingCount ?? 0 }} awaiting review</p>
                                            <a href="{{ route('posts.index', ['filter' => 'pending']) }}"
                                                class="btn btn-sm btn-danger">
                                                See Pending
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endauth --}}

                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-6 row gy-6">
                        @foreach ($posts as $post)
                            <div class="col-sm-6 col-lg-4">
                                <div class="p-2 border shadow-none card h-100">
                                    <div class="mb-4 overflow-hidden rounded-2" style="height: 220px;">
                                        <a href="{{ route('posts.show', $post->id) }}">
                                            @if ($post->image)
                                                <img src="{{ asset('storage/' . $post->image) }}"
                                                    alt="{{ $post->title }}" class="w-100 h-100 object-fit-cover" />
                                            @else
                                                <img src="{{ asset('assets/img/pages/app-academy-tutor-1.png') }}"
                                                    alt="default image" class="w-100 h-100 object-fit-cover" />
                                            @endif
                                        </a>
                                    </div>

                                    <div class="p-4 pt-2 card-body">
                                        <div class="mb-4 d-flex justify-content-between align-items-center">
                                            @if ($post->category)
                                                <span class="badge bg-label-primary">{{ $post->category->name }}</span>
                                            @endif
                                        </div>
                                        <a href="{{ route('posts.show', $post->id) }}"
                                            class="h5">{{ $post->title }}</a>
                                        <p class="mt-1">{{ Str::limit(strip_tags($post->body), 100) }}</p>
                                        <p class="mb-1 d-flex align-items-center">
                                            <i
                                                class="icon-base ti tabler-clock me-1"></i>{{ $post->created_at->diffForHumans() }}
                                        </p>
                                        <div
                                            class="flex-wrap gap-4 d-flex flex-column flex-md-row text-nowrap flex-md-nowrap flex-lg-wrap flex-xxl-nowrap">
                                            <a class="w-100 btn btn-label-primary d-flex align-items-center waves-effect"
                                                href="{{ route('posts.show', $post->id) }}">
                                                <span class="me-2">View Post</span><i
                                                    class="icon-base ti tabler-chevron-right icon-xs lh-1 scaleX-n1-rtl"></i>
                                            </a>
                                        </div>
                                        @auth
                                            @if (auth()->user()->hasRole('super_admin') || auth()->user()->hasRole('society_admin'))
                                                @if ($post->status === 'pending')
                                                    <form action="{{ route('admin.posts.changeStatus', $post->id) }}"
                                                        method="POST" class="mt-2 w-100">
                                                        @csrf
                                                        <input type="hidden" name="status" value="approved">
                                                        <button type="submit" class="btn btn-success w-100"
                                                            onclick="return confirm('Approve this post?')">
                                                            Approve Post
                                                        </button>
                                                    </form>
                                                @endif
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <nav aria-label="Page navigation" class="d-flex align-items-center justify-content-center">
                        {{ $posts->links('pagination::bootstrap-5') }}
                        <!-- Adjust pagination view if needed to match classes -->
                    </nav>
                </div>
            </div>

            <div class="mb-6 row gy-4">
                {{-- Approved Posts --}}
                <div class="col-lg-6">
                    <div class="p-4 border rounded d-flex align-items-center border-primary h-100">
                        <i class="icon-base ti tabler-checkbox icon-2x text-primary me-4"></i>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-primary">Approved Posts</h5>
                            <p class="mb-2 text-body-secondary">{{ $approvedCount ?? 0 }} in your society</p>
                            <a href="{{ route('posts.index', ['filter' => 'approved']) }}" class="btn btn-sm btn-primary">
                                View All
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Pending Submissions --}}
                <div class="col-lg-6">
                    <div class="p-4 border rounded d-flex align-items-center border-danger h-100">
                        <i class="icon-base ti tabler-clock icon-2x text-danger me-4"></i>
                        <div class="flex-grow-1">
                            <h5 class="mb-1 text-danger">Your Pending</h5>
                            <p class="mb-2 text-body-secondary">{{ $pendingCount ?? 0 }} awaiting review</p>
                            <a href="{{ route('posts.index', ['filter' => 'pending']) }}" class="btn btn-sm btn-danger">
                                See My Pending
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@section('page-js')
    <script src="{{ asset('assets/js/app-academy-course.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const categoryFilter = document.getElementById('categoryFilter');

            categoryFilter.addEventListener('change', function() {
                const selectedCategory = this.value;
                const url = new URL(window.location.href);

                if (selectedCategory) {
                    url.searchParams.set('category', selectedCategory);
                } else {
                    url.searchParams.delete('category');
                }

                window.location.href = url.toString();
            });
        });
    </script>

@endsection
@endsection
