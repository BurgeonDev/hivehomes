@extends('frontend.layouts.app')
@section('title', $post->title)

@php
    use Illuminate\Support\Str;
    // Simple reading time estimate (200 wpm)
    $plainBody = strip_tags($post->body ?? '');
    $words = str_word_count($plainBody);
    $readingMinutes = max(1, (int) ceil($words / 200));
    $commentsCount = $post->comments()->count();
@endphp

@section('content')
    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">
        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item">
                        <a href="{{ route('posts.index') }}" class="text-decoration-none text-dark">Posts</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ Str::limit($post->title, 40) }}</li>
                </ol>
            </nav>
        </div>
    </section>

    <section class="section-py bg-body first-section-pt">
        <div class="container">
            <div class="row g-4">
                <!-- Main content -->
                <div class="col-lg-8">
                    <div class="shadow-sm card">
                        <div class="p-4 card-body">
                            <h1 class="mb-1 h3">{{ $post->title }}</h1>

                            <div class="mb-3 d-flex align-items-center">
                                <small class="text-muted me-3">By <strong>{{ $post->user->name }}</strong></small>
                                <small class="text-muted me-3">· {{ $readingMinutes }} min read</small>
                                <small class="text-muted me-3">· {{ optional($post->created_at)->format('F j, Y') }}</small>
                                <span class="badge bg-label-primary text-capitalize ms-auto">
                                    {{ $post->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>

                            @if ($post->image)
                                <figure class="mb-4">
                                    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                        class="rounded w-100" style="height: 420px; object-fit: cover;">
                                    @if ($post->image_caption ?? false)
                                        <figcaption class="mt-2 small text-muted">{{ $post->image_caption }}</figcaption>
                                    @endif
                                </figure>
                            @endif

                            <div class="mb-4 post-body">
                                {!! $post->body !!}
                            </div>

                            {{-- Post meta cards --}}
                            <div class="mb-4 row g-3">
                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Views</small>
                                            <strong>{{ $post->views ?? 0 }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Comments</small>
                                            <strong>{{ $commentsCount }}</strong>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Status</small>
                                            <strong class="text-capitalize">{{ $post->status ?? '—' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Tags & Share --}}
                            <div class="flex-wrap gap-2 mb-4 d-flex align-items-center">
                                @if ($post->tags)
                                    @foreach ($post->tags as $tag)
                                        <a href="{{ route('posts.index', ['tag' => $tag->slug ?? $tag->name]) }}"
                                            class="badge bg-label-secondary text-decoration-none text-capitalize">{{ $tag->name }}</a>
                                    @endforeach
                                @endif

                                <div class="gap-2 ms-auto d-flex align-items-center">
                                    <span class="small text-muted">Share:</span>
                                    <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->fullUrl()) }}"
                                        target="_blank" class="btn btn-sm btn-outline-primary">Facebook</a>
                                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->fullUrl()) }}&text={{ urlencode($post->title) }}"
                                        target="_blank" class="btn btn-sm btn-outline-info">Twitter</a>
                                </div>
                            </div>

                            <hr>

                            {{-- Details block (cleaner) --}}
                            <div class="mb-3 row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <small class="text-muted">Society</small>
                                            <div>{{ optional($post->society)->name ?? '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <small class="text-muted">Last updated</small>
                                            <div>{{ optional($post->updated_at)->format('F j, Y') ?? '—' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Author mini & CTA --}}
                            <div class="mb-4 border-0 shadow-sm card">
                                <div class="card-body d-flex align-items-center">
                                    @if (!empty($post->user->profile_pic))
                                        <img src="{{ asset('storage/' . $post->user->profile_pic) }}"
                                            alt="{{ $post->user->name }}" class="rounded-circle me-3" width="64"
                                            height="64" style="object-fit: cover;">
                                    @else
                                        <div class="text-white avatar avatar-md bg-primary rounded-circle d-inline-flex align-items-center justify-content-center me-3"
                                            style="width:64px;height:64px;">
                                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                        </div>
                                    @endif

                                    <div>
                                        <div class="fw-semibold">{{ $post->user->name }}</div>
                                        <small
                                            class="text-muted">{{ $post->user->getRoleNames()->first() ?? 'User' }}</small>
                                    </div>

                                    <div class="ms-auto">
                                        <a href="mailto:{{ $post->user->email }}"
                                            class="btn btn-sm btn-outline-primary">Contact author</a>
                                    </div>
                                </div>
                            </div>

                            {{-- Comments form --}}
                            <div class="mb-4">
                                <h5 class="mb-3">Leave a Comment</h5>

                                @auth
                                    <form action="{{ route('comments.store', $post->id) }}" method="POST"
                                        class="p-3 shadow-sm card">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="body" class="form-label">Your Comment</label>
                                            <textarea name="body" id="body" class="form-control" rows="4" required></textarea>
                                        </div>

                                        <div class="mb-2 row g-2">
                                            <div class="col-md-6">
                                                <label for="rating" class="form-label">Rating</label>
                                                <select name="rating" class="form-select" id="rating">
                                                    <option value="">No rating</option>
                                                    @for ($i = 5; $i >= 1; $i--)
                                                        <option value="{{ $i }}">{{ $i }} Star</option>
                                                    @endfor
                                                </select>
                                            </div>
                                            <div class="col-md-6 d-flex align-items-end justify-content-end">
                                                <button class="btn btn-primary">Post Comment</button>
                                            </div>
                                        </div>
                                    </form>
                                @else
                                    <div class="alert alert-info">
                                        Please <a href="{{ route('login') }}">login</a> to comment.
                                    </div>
                                @endauth
                            </div>

                            {{-- Comments list --}}
                            <div class="mb-5">
                                <h5 class="mb-3">Comments ({{ $commentsCount }})</h5>

                                @forelse ($post->comments()->latest()->get() as $comment)
                                    <div class="mb-3 shadow-sm card">
                                        <div class="card-body">
                                            <div class="d-flex">
                                                @if (!empty($comment->user->profile_pic))
                                                    <img src="{{ asset('storage/' . $comment->user->profile_pic) }}"
                                                        class="rounded-circle me-3" width="48" height="48"
                                                        style="object-fit:cover;">
                                                @else
                                                    <div class="text-white rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-3"
                                                        style="width:48px;height:48px;">
                                                        {{ strtoupper(substr($comment->user->name, 0, 1)) }}
                                                    </div>
                                                @endif

                                                <div class="flex-grow-1">
                                                    <div class="d-flex align-items-center">
                                                        <strong>{{ $comment->user->name }}</strong>
                                                        <small
                                                            class="text-muted ms-3">{{ $comment->created_at->diffForHumans() }}</small>

                                                        @if ($comment->rating)
                                                            <span class="ms-3 text-warning"> {!! str_repeat('★', $comment->rating) !!}
                                                            </span>
                                                        @endif

                                                        <div class="ms-auto">
                                                            {{-- Example moderation/like buttons --}}
                                                            <a href="#"
                                                                class="btn btn-sm btn-outline-secondary me-1">Like</a>
                                                            @can('delete', $comment)
                                                                <form action="{{ route('comments.destroy', $comment->id) }}"
                                                                    method="POST" class="d-inline">
                                                                    @csrf @method('DELETE')
                                                                    <button
                                                                        class="btn btn-sm btn-outline-danger">Delete</button>
                                                                </form>
                                                            @endcan
                                                        </div>
                                                    </div>

                                                    <p class="mt-2 mb-0">{{ $comment->body }}</p>

                                                    {{-- Optional replies placeholder --}}
                                                    @if ($comment->replies && $comment->replies->count())
                                                        <div class="mt-3 ms-5">
                                                            @foreach ($comment->replies as $reply)
                                                                <div class="mb-2 card card-sm">
                                                                    <div class="p-2 card-body">
                                                                        <small
                                                                            class="text-muted"><strong>{{ $reply->user->name }}</strong>
                                                                            ·
                                                                            {{ $reply->created_at->diffForHumans() }}</small>
                                                                        <div class="mt-1">{{ $reply->body }}</div>
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="shadow-sm card">
                                        <div class="card-body">
                                            <p class="mb-0">No comments yet. Be the first to comment!</p>
                                        </div>
                                    </div>
                                @endforelse
                            </div>
                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 95px;">
                        {{-- Author / Profile Card --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="text-center card-body">
                                @if (!empty($post->user->profile_pic))
                                    <img src="{{ asset('storage/' . $post->user->profile_pic) }}"
                                        alt="{{ $post->user->name }}" class="mb-2 rounded-circle" width="80"
                                        height="80" style="object-fit:cover;">
                                @else
                                    <div class="mb-2 text-white avatar avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:80px;height:80px;">
                                        {{ strtoupper(substr($post->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <h6 class="mb-0">{{ $post->user->name }}</h6>
                                <small class="text-muted">{{ $post->user->getRoleNames()->first() ?? 'User' }}</small>

                                <div class="mt-3">
                                    <a href="{{ route('posts.index', ['author' => $post->user->id]) }}"
                                        class="mb-2 btn btn-sm btn-outline-primary w-100">More by author</a>
                                    <a href="mailto:{{ $post->user->email }}"
                                        class="btn btn-sm btn-primary w-100">Contact</a>
                                </div>
                            </div>
                        </div>

                        {{-- Quick stats / CTA --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="card-body">
                                <h6 class="mb-2">Quick Info</h6>
                                <ul class="mb-0 list-unstyled small">
                                    <li><strong>Published:</strong> {{ optional($post->created_at)->format('F j, Y') }}
                                    </li>
                                    <li><strong>Reading:</strong> {{ $readingMinutes }} min</li>
                                    <li><strong>Category:</strong> {{ $post->category->name ?? '—' }}</li>
                                </ul>
                            </div>
                        </div>

                        {{-- Related posts --}}
                        @php
                            $related = \App\Models\Post::where('category_id', $post->category_id)
                                ->where('id', '!=', $post->id)
                                ->latest()
                                ->take(4)
                                ->get();
                        @endphp
                        @if ($related->count())
                            <div class="mb-3 shadow-sm card">
                                <div class="card-body">
                                    <h6 class="mb-3">Related Posts</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($related as $r)
                                            <li class="mb-2">
                                                <a href="{{ route('posts.show', $r->id) }}" class="text-decoration-none">
                                                    {{ Str::limit($r->title, 60) }}
                                                    <br><small
                                                        class="text-muted">{{ $r->created_at->diffForHumans() }}</small>
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('posts.index', ['category' => $post->category_id]) }}"
                                        class="btn btn-sm btn-outline-primary w-100">See more</a>
                                </div>
                            </div>
                        @endif



                    </div> {{-- sticky --}}
                </div>
            </div>
        </div>
    </section>
@endsection
