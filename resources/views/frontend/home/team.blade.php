<section id="landingPosts" class="section-py landing-team">
    <div class="container">
        <div class="mb-4 text-center">
            <span class="badge bg-label-primary">Latest Posts</span>
        </div>
        <h4 class="mb-1 text-center">
            <span class="position-relative fw-extrabold z-1">
                Community Updates
                <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="posts"
                    class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
            </span>
            from your society
        </h4>
        <p class="pb-0 text-center mb-md-11 pb-xl-12">
            Stay updated with the latest announcements, discussions, and activities.
        </p>

        @php
            $query = \App\Models\Post::query()->latest();

            if (auth()->check()) {
                $user = auth()->user();

                if ($user->hasRole('society_admin') || $user->hasRole('member')) {
                    $query->where('society_id', $user->society_id);
                }
                // super_admin sees all
            }

            $posts = $query->take(4)->where('status', 'approved')->get(); // match team layout with 4 items
        @endphp

        <div class="mt-2 row gy-12">
            @forelse ($posts as $index => $post)
                @php
                    // Rotate label colors like team cards
                    $colors = ['primary', 'info', 'danger', 'success'];
                    $color = $colors[$index % count($colors)];

                    $imagePath = $post->image
                        ? asset('storage/' . $post->image)
                        : asset('assets/img/front-pages/placeholder.png');
                @endphp

                <div class="col-lg-3 col-sm-6">
                    <div class="mt-3 shadow-none card mt-lg-0">
                        <div class="border bg-label-{{ $color }} border-bottom-0 border-label-{{ $color }} team-image-box d-flex align-items-center justify-content-center"
                            style="height: 180px; overflow: hidden;">

                            @if ($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" class="rounded img-fluid h-100 w-100"
                                    style="object-fit: cover;" alt="post image" />
                            @else
                                <img class="rounded no-image-placeholder img-fluid h-100 w-100"
                                    style="object-fit: cover;" />
                            @endif
                        </div>


                        <div class="text-center border card-body border-top-0 border-label-{{ $color }}">
                            <h5 class="mb-0 card-title text-truncate">{{ $post->title }}</h5>
                            <p class="mb-0 text-body-secondary text-truncate">{{ Str::limit($post->content, 50) }}</p>
                            <a href="{{ route('posts.show', $post->id) }}"
                                class="btn btn-sm btn-outline-{{ $color }} mt-2">
                                Read More
                            </a>
                        </div>
                    </div>
                </div>

            @empty
                <p class="text-center">No posts available right now.</p>
            @endforelse
        </div>
    </div>
</section>
