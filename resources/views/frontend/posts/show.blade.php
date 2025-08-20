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
                <div class="row g-0">
                    <!-- Left: Post Content -->
                    <div class="col-lg-8 card-body border-end p-md-8">
                        <h2 class="mb-2">{{ $post->title }}</h2>

                        <p class="mb-4">
                            By <strong>{{ $post->user->name }}</strong> in
                            <span class="badge bg-label-primary text-capitalize">
                                {{ $post->category->name ?? 'Uncategorized' }}
                            </span>
                        </p>

                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                class="mb-4 rounded w-100" style="height: 400px; object-fit: cover;">
                        @endif

                        <div class="mb-6">{!! $post->body !!}</div>

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

                    <!-- Right: Author Info -->
                    <div class="col-lg-4 card-body p-md-8">
                        <div class="mb-4 shadow-sm card">
                            <div class="text-center card-body">
                                @if (!empty($post->user->profile_pic))
                                    <img src="{{ asset('storage/' . $post->user->profile_pic) }}"
                                        alt="{{ $post->user->name }}" class="mb-3 rounded-circle" width="100"
                                        height="100" style="object-fit: cover;">
                                @else
                                    <div class="mx-auto mb-3 text-white avatar avatar-lg bg-primary rounded-circle"
                                        style="width: 100px; height: 100px; font-size: 36px; line-height: 100px;">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <h5 class="mb-1">{{ $post->user->name }}</h5>
                                <span class="mb-3 badge bg-label-secondary">Author</span>

                                <p class="mb-1"><strong>Role:</strong>
                                    {{ $post->user->getRoleNames()->first() ?? 'User' }}</p>
                                <p><strong>Email:</strong> {{ $post->user->email }}</p>

                                <a href="mailto:{{ $post->user->email }}" class="mt-2 btn btn-outline-primary">Contact
                                    Author</a>
                            </div>
                        </div>

                        <!-- Author's Other Posts -->
                        @php
                            $authorPosts = $post->user->posts()->where('id', '!=', $post->id)->latest()->take(3)->get();
                        @endphp

                        @if ($authorPosts->count())
                            <div class="shadow-sm card">
                                <div class="card-header bg-light">
                                    <h6 class="mb-0">Other Posts by {{ $post->user->name }}</h6>
                                </div>
                                <div class="card-body">
                                    <ul class="list-unstyled">
                                        @foreach ($authorPosts as $aPost)
                                            <li class="mb-3">
                                                <a href="{{ route('posts.show', $aPost->id) }}"
                                                    class="text-decoration-none">
                                                    <strong>{{ $aPost->title }}</strong>
                                                    <br>
                                                    <small
                                                        class="text-muted">{{ $aPost->created_at->diffForHumans() }}</small>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('posts.index') }}" class="btn btn-sm btn-primary">See All Posts</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Comments Section --}}
            <hr class="my-6">
            <h4 class="mb-3">Leave a Comment</h4>

            @auth
                <form action="{{ route('comments.store', $post->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="body" class="form-label">Your Comment</label>
                        <textarea name="body" id="body" class="form-control" rows="4" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" class="form-select" id="rating">
                            <option value="">No rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}">{{ $i }} Star</option>
                            @endfor
                        </select>
                    </div>
                    <button class="btn btn-primary">Post Comment</button>
                </form>
            @else
                <p>Please <a href="{{ route('login') }}">login</a> to comment.</p>
            @endauth

            {{-- Display Comments --}}
            <hr class="my-6">
            <h4 class="mb-3">Comments ({{ $post->comments->count() }})</h4>

            @forelse ($post->comments()->latest()->get() as $comment)
                <div class="pb-3 mb-4 border-bottom">
                    <div class="mb-2 d-flex align-items-center">
                        @if (!empty($comment->user->profile_pic))
                            <img src="{{ asset('storage/' . $comment->user->profile_pic) }}" class="rounded-circle me-2"
                                width="40" height="40" style="object-fit: cover;">
                        @else
                            <div class="text-white avatar bg-primary rounded-circle me-2 d-flex align-items-center justify-content-center"
                                style="width: 40px; height: 40px;">
                                {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <strong>{{ $comment->user->name }}</strong>
                            @if ($comment->rating)
                                <span class="text-warning">({{ $comment->rating }}★)</span>
                            @endif
                            <br>
                            <small class="text-muted">{{ $comment->created_at->diffForHumans() }}</small>
                        </div>
                    </div>
                    <p class="mt-2 mb-0">{{ $comment->body }}</p>
                </div>
            @empty
                <p>No comments yet.</p>
            @endforelse
        </div>
    </section>

@endsection
