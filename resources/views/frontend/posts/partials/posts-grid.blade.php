<div id="postsContainer">
    <div class="row gy-4">
        @forelse($posts as $post)
            @php
                $plain = strip_tags($post->body ?? '');
                $words = str_word_count($plain);
                $comments = $post->comments_count ?? $post->comments()->count();
            @endphp

            <div class="col-md-6">
                <article class="card product-card post-card h-100 d-flex flex-column">
                    <div class="row g-0 flex-grow-1">
                        {{-- Image Column (left) --}}
                        <div class="col-6">
                            <a href="{{ route('posts.show', $post->id) }}" class="d-block h-100">
                                <div class="product-image-wrap">
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                                            class="product-media w-100 h-100 object-fit-cover">
                                    @else
                                        <div class="no-image-placeholder">No Image</div>
                                    @endif

                                    {{-- Category badge on image (solid look) --}}
                                    @if ($post->category)
                                        <span class="text-dark badge bg-label-primary product-cat-badge">
                                            {{ $post->category->name }}
                                        </span>
                                    @endif
                                </div>
                            </a>
                        </div>

                        {{-- Content Column (right) --}}
                        <div class="col-6">
                            <div class="card-body d-flex flex-column h-100">
                                <div>
                                    <div class="mb-1 d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1 product-title">
                                            <a href="{{ route('posts.show', $post->id) }}"
                                                class="text-dark text-decoration-none">
                                                {{ Str::limit($post->title, 80) }}
                                            </a>
                                        </h6>
                                    </div>

                                    <p class="mb-1 small-muted">
                                        <span class="text-muted">
                                            @if ($post->user)
                                                {{ $post->user->name }} &middot;
                                            @endif
                                            {{ $post->created_at->format('d M, Y') }}
                                        </span>
                                    </p>

                                    <p class="mb-2 small text-muted">{{ Str::limit($plain, 110) }}</p>

                                    <div class="flex-wrap gap-2 mb-2 d-flex">
                                        <span class="text-dark meta-pill bg-label-secondary">Words:
                                            {{ $words }}</span>
                                        <span class="text-dark meta-pill bg-label-secondary">Comments:
                                            {{ $comments }}</span>
                                        <span class="text-dark meta-pill bg-label-secondary">
                                            Views: {{ number_format($post->views ?? 0) }}
                                        </span>
                                    </div>
                                </div>

                                {{-- bottom meta row inside body --}}
                                <div class="mt-auto d-flex justify-content-between align-items-center">
                                    <div class="d-flex align-items-center">
                                        @if ($post->user && $post->user->profile_pic)
                                            <img src="{{ asset('storage/' . $post->user->profile_pic) }}"
                                                class="rounded-circle me-2" width="32" height="32"
                                                style="object-fit:cover;">
                                        @else
                                            <div class="text-white rounded-circle bg-primary d-inline-flex align-items-center justify-content-center me-2"
                                                style="width:32px;height:32px;font-size:.85rem;">
                                                {{ strtoupper(substr(optional($post->user)->name ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <small class="text-muted">{{ optional($post->user)->name }}</small>
                                    </div>

                                    <div class="gap-2 d-flex align-items-center">
                                        <small class="text-muted">
                                            <i
                                                class="menu-icon icon-base ti tabler-eye me-1"></i>{{ number_format($post->views ?? 0) }}
                                        </small>
                                        <small class="text-muted ms-2">
                                            <i
                                                class="menu-icon icon-base ti tabler-message-circle me-1"></i>{{ $comments }}
                                        </small>
                                        <small class="text-muted ms-2">
                                            <i class="menu-icon icon-base ti tabler-heart me-1"></i>
                                            <span
                                                class="like-count">{{ number_format($post->likes_count ?? 0) }}</span>
                                        </small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer with actions --}}
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="gap-2 d-flex w-50">
                                <a href="{{ route('posts.show', $post->id) }}"
                                    class="btn btn-sm rounded-pill btn-outline-primary w-100">
                                    <i class="ti tabler-eye me-1"></i> View Post
                                </a>
                            </div>

                            <div class="gap-2 d-flex align-items-center">
                                @php $liked = in_array($post->id, $likedPostIds); @endphp

                                <button
                                    class="btn btn-xl like-button {{ $liked ? 'btn-danger text-danger' : 'btn-outline-danger' }}"
                                    data-post-id="{{ $post->id }}" aria-pressed="{{ $liked ? 'true' : 'false' }}">
                                    <i class="ti tabler-heart"></i>
                                </button>


                                {{-- Owner-only Edit (preserves existing logic & modal include) --}}
                                @if (auth()->id() === $post->user_id)
                                    <button class="btn btn-sm btn-outline-warning" data-bs-toggle="modal"
                                        data-bs-target="#editPostModal-{{ $post->id }}">
                                        <i class="ti tabler-edit me-1"></i> Edit
                                    </button>
                                @endif

                                <span class="small text-muted ms-2">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>
                </article>

                {{-- include edit modal/partial as before --}}
                @include('frontend.posts.partials.edit-post', [
                    'post' => $post,
                    'categories' => $categories,
                ])
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
</div>
