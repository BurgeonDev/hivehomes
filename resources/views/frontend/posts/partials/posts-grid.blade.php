<div class="row gy-4">
    @forelse($posts as $post)
        @php
            $plain = strip_tags($post->body ?? '');
            $words = str_word_count($plain);
            $readMinutes = max(1, (int) ceil($words / 200));
            $comments = $post->comments_count ?? $post->comments()->count();
        @endphp

        <div class="col-sm-6">
            <article class="shadow-sm card post-card h-100 d-flex flex-column">
                <div class="row g-0 flex-grow-1">
                    <div class="col-5">
                        <a href="{{ route('posts.show', $post->id) }}" class="overflow-hidden d-block rounded-start">
                            <img src="{{ $post->image ? asset('storage/' . $post->image) : asset('assets/img/pages/app-academy-tutor-1.png') }}"
                                alt="{{ $post->title }}" class="img-fluid post-img w-100 h-100 object-fit-cover"
                                style="height:180px;">
                        </a>
                    </div>
                    <div class="col-7">
                        <div class="card-body d-flex flex-column">
                            <div class="mb-2 d-flex align-items-start">
                                @if ($post->category)
                                    <span class="badge bg-label-primary text-capitalize me-2">
                                        {{ $post->category->name }}
                                    </span>
                                @endif
                                <small class="text-muted ms-auto">{{ $post->created_at->format('M j, Y') }}</small>
                            </div>
                            <h5 class="mb-1 h6">
                                <a href="{{ route('posts.show', $post->id) }}" class="text-decoration-none text-dark">
                                    {{ Str::limit($post->title, 78) }}
                                </a>
                            </h5>
                            <p class="mb-2 excerpt">{{ Str::limit($plain, 120) }}</p>
                            <div class="gap-2 mt-auto d-flex align-items-center post-meta">
                                <div class="d-flex align-items-center author-chip">
                                    @if ($post->user->profile_pic)
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
                                <small class="text-muted ms-2">{{ $readMinutes }} min read</small>
                                <small class="text-muted ms-2">
                                    <i
                                        class="menu-icon icon-base ti tabler-eye me-1"></i>{{ number_format($post->views ?? 0) }}
                                </small>
                                <small class="text-muted ms-2">
                                    <i
                                        class="menu-icon icon-base ti tabler-message-circle me-1"></i>{{ $comments }}
                                </small>
                                <div class="ms-2 d-flex align-items-center like-button-wrapper">
                                    @php $liked = in_array($post->id, $likedPostIds); @endphp
                                    <button
                                        class="btn btn-icon border-0 bg-transparent like-button {{ $liked ? 'liked text-danger' : 'text-muted' }}"
                                        data-post-id="{{ $post->id }}"
                                        aria-pressed="{{ $liked ? 'true' : 'false' }}">
                                        <i class="ti tabler-heart fs-5"></i>
                                    </button>
                                    <span
                                        class="ms-1 text-muted like-count">{{ number_format($post->likes_count) }}</span>
                                </div>


                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer border-top-0">
                    <a href="{{ route('posts.show', $post->id) }}" class="btn btn-label-primary w-100">
                        <i class="menu-icon icon-base ti tabler-eye me-1"></i> View Post
                    </a>
                </div>
            </article>
        </div>
    @empty
        <div class="col-12">
            <div class="shadow-sm card">
                <div class="py-5 text-center card-body">
                    <h5 class="mb-1">No posts found</h5>
                    <p class="mb-3 text-muted">There are no posts to show right now.</p>
                    <a href="{{ route('posts.index') }}" class="btn btn-outline-primary">Reset filters</a>
                </div>
            </div>
        </div>
    @endforelse
</div>

{{-- Pagination --}}
<div class="mt-4 d-flex justify-content-center">
    {{ $posts->appends(request()->query())->links('pagination::bootstrap-5') }}
</div>
