@extends('frontend.layouts.app')
@section('title', $post->title)

@section('content')

    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">

        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Post</li>
                </ol>
            </nav>
        </div>
    </section>
    <section class="section-py bg-body first-section-pt">
        <div class="container">
            <div class="px-3 card">
                <div class="row">

                    <div class="col-lg-8 card-body border-end p-md-8">
                        <h4 class="mb-2">{{ $post->title }}</h4>

                        <p class="mb-4">
                            By <span class="fw-medium text-heading">{{ $post->user->name }}</span>
                            in
                            <span class="badge bg-label-primary text-capitalize">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                        </p>

                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="mb-4 rounded img-fluid">
                        @endif

                        <div class="mb-6">
                            {{-- Render body as HTML. If your posts are plain text, sanitize before saving or switch back to nl2br(e()) --}}
                            {!! $post->body !!}
                        </div>

                        <hr class="my-6">

                        <h5 class="mb-3">Details</h5>
                        <ul class="list-unstyled">
                            <li><strong>Society:</strong> {{ optional($post->society)->name ?? '—' }}</li>
                            <li><strong>Status:</strong> {{ ucfirst($post->status ?? 'unknown') }}</li>
                            <li><strong>Published:</strong> {{ optional($post->created_at)->format('F j, Y') ?? '—' }}</li>
                            <li><strong>Last updated:</strong> {{ optional($post->updated_at)->format('F j, Y') ?? '—' }}
                            </li>
                        </ul>
                    </div>

                    {{-- Right: Author Card (4 cols) --}}
                    <div class="col-lg-4 card-body p-md-8">
                        <div class="mb-6 card">
                            <div class="pt-12 card-body">
                                <div class="mb-6 text-center user-avatar-section">
                                    @if (!empty($post->user->profile_photo_url))
                                        <img src="{{ $post->user->profile_photo_url }}" alt="{{ $post->user->name }}"
                                            class="mb-4 img-fluid rounded-circle" width="120" height="120">
                                    @endif

                                    <h5>{{ $post->user->name }}</h5>
                                    <span class="badge bg-label-secondary">Author</span>
                                </div>

                                {{-- Stats: use post count --}}
                                <div class="flex-wrap my-6 d-flex justify-content-around">
                                    <div class="text-center">
                                        <div class="mb-2 rounded avatar avatar-initial bg-label-primary">
                                            <i class="icon-base ti tabler-file-text icon-lg"></i>
                                        </div>
                                        <h5 class="mb-0">{{ $post->user->posts()->count() }}</h5>
                                        <small>Posts Written</small>
                                    </div>
                                </div>

                                <h5 class="pb-4 mb-4 border-bottom">Contact</h5>
                                <ul class="mb-6 list-unstyled">
                                    <li class="mb-2">
                                        <span class="h6">Email:</span>
                                        <span>{{ $post->user->email }}</span>
                                    </li>
                                    <li class="mb-2">
                                        <span class="h6">Role:</span>
                                        <span
                                            class="text-capitalize">{{ $post->user->getRoleNames()->first() ?? 'User' }}</span>
                                    </li>
                                </ul>

                                <div class="d-flex justify-content-center">
                                    <a href="mailto:{{ $post->user->email }}"
                                        class="btn btn-primary me-2 waves-effect waves-light">Email Author</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
