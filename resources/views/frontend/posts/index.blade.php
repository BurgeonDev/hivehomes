@extends('frontend.layouts.app')
@section('title', 'Posts')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/plyr/plyr.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/typography.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/highlight/highlight.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/katex.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/quill/editor.css') }}" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <style>
        /**
                     * Minimal product-style imports for posts
                     * - Only includes the product-card/image/badge/footer styles used by posts
                     * - Keeps post-specific styles for excerpt, author-chip, like button
                     *
                     * Replace the current <style> in your posts page with this block.
                     */

        /* === Product card base (minimal) === */
        #postsContainer .product-card {
            border-radius: .75rem;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(12, 20, 40, 0.06);
            transition: box-shadow .28s ease, transform .18s ease;
            display: flex;
            flex-direction: column;
            height: 100%;
        }

        #postsContainer .product-card:hover {
            box-shadow: 0 12px 40px rgba(12, 20, 40, 0.09);
            transform: translateY(-2px);
        }

        /* Ensure card-body/footer padding matches products */
        #postsContainer .product-card .card-body {
            padding: .9rem;
        }

        #postsContainer .product-card .card-footer {
            background: transparent;
            border-top: 1px dashed rgba(0, 0, 0, 0.04);
            padding: .55rem .9rem;
        }

        /* === Image wrap & media (same heights as products) === */
        #postsContainer .product-image-wrap {
            position: relative;
            overflow: hidden;
            height: 180px;
            background: #f8f9fa;
        }



        #postsContainer .product-media,
        #postsContainer .post-img {
            height: 180px;
            width: 100%;
            object-fit: cover;
            display: block;
        }

        /* small fallback when no image */
        #postsContainer .no-image-placeholder {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, #adb5bd, #6c757d);
        }

        /* === Badges (category / featured) === */
        #postsContainer .product-cat-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            z-index: 5;
            font-size: .78rem;
            padding: .35rem .6rem;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(12, 20, 40, 0.08);
        }

        #postsContainer .product-featured-badge {
            position: absolute;
            right: 12px;
            top: 12px;
            z-index: 5;
            font-size: .75rem;
            padding: .28rem .45rem;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(12, 20, 40, 0.08);
        }

        /* === Title / meta shared styles === */
        #postsContainer .product-title {
            font-weight: 600;
            font-size: 1rem;
            line-height: 1.1;
            margin-bottom: 0;
        }

        #postsContainer .product-title a {
            display: block;
            max-width: 100%;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        #postsContainer .meta-pill {
            font-size: .78rem;
            padding: .28rem .6rem;
            border-radius: 999px;
            display: inline-block;
            margin-right: .4rem;
        }

        #postsContainer .small-muted {
            color: #6b7280;
            font-size: .85rem;
        }

        /* === Post-specific styles === */
        /* Keep the post-card wrapper class in case it's used elsewhere */
        #postsContainer .post-card {
            /* already covered by #postsContainer .product-card */
        }

        #postsContainer .excerpt {
            color: #6b7280;
            font-size: .92rem;
            margin-bottom: .5rem;
            line-height: 1.35;
        }

        /* author chip */
        #postsContainer .author-chip {
            display: flex;
            align-items: center;
            gap: .4rem;
        }

        #postsContainer .author-chip img {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            object-fit: cover;
        }

        /* bottom meta row inside card-body for posts */
        #postsContainer .post-meta {
            gap: .6rem;
            align-items: center;
            font-size: .9rem;
            color: #6b7280;
        }

        /* Like button (visual only) */
        #postsContainer .like-button {
            border-radius: 999px;
            width: 40px;
            height: 40px;
            padding: 0;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            transition: background-color .18s ease, color .18s ease, transform .12s ease;
            border: 1px solid rgba(0, 0, 0, 0.06);
            background: transparent;
            color: #6b7280;
        }

        #postsContainer .like-button:hover {
            transform: translateY(-1px);
        }

        #postsContainer .like-button.liked,
        #postsContainer .like-button.liked i {
            color: #dc3545 !important;
            border-color: rgba(220, 53, 69, 0.12);
            background: rgba(220, 53, 69, 0.04);
        }

        /* Footer buttons spacing in posts (match product buttons) */
        #postsContainer .post-card .card-footer .btn {
            height: 36px;
            padding: .25rem .75rem;
            font-size: .88rem;
            border-radius: .45rem;
        }

        /* === Responsive adjustments === */
        @media (max-width: 767.98px) {

            #postsContainer .product-image-wrap,
            #postsContainer .product-media,
            #postsContainer .post-img,
            #postsContainer .no-image-placeholder {
                height: 140px;
            }

            #postsContainer .product-card,
            #postsContainer .post-card {
                border-radius: .6rem;
            }

            #postsContainer .product-title {
                font-size: .97rem;
            }
        }
    </style>

@endsection

@section('content')
    {{-- Banner / Breadcrumb (unchanged) --}}
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
        <div class="row g-4">
            {{-- Main content --}}
            <div class="col-lg-10">

                {{-- KPI + Add (unchanged) --}}
                <div class="mb-4 card">
                    <div class="gap-3 card-body d-flex flex-column flex-md-row align-items-start">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">Society Posts</h4>
                            <p class="mb-0 text-muted">Browse posts from your society</p>
                        </div>
                        <div class="gap-2 d-flex align-items-center">
                            <button type="button" class="btn btn-label-primary waves-effect">
                                Total posts
                                <span
                                    class="text-white badge bg-primary badge-center ms-1">{{ number_format($approvedCount ?? 0) }}</span>
                            </button>

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
                    {{-- NOTE: inputs are prefilled from request() so state persists after filters/pagination --}}
                    <form id="postsFilterForm" class="row g-2 align-items-center">
                        <div class="col-md-6">
                            <input type="search" name="q" id="q"
                                placeholder="Search posts, titles, content..." class="form-control form-control-sm"
                                value="{{ request('q') }}" autocomplete="off" />
                        </div>
                        <div class="col-md-3">
                            <select name="category" id="categoryFilter" class="form-select form-select-sm">
                                <option value="">All categories</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ (string) request('category') === (string) $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="gap-2 col-md-3 d-flex">
                            <select name="sort" id="sortFilter" class="form-select form-select-sm">
                                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>
                                    Latest</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest</option>
                                <option value="most_viewed" {{ request('sort') === 'most_viewed' ? 'selected' : '' }}>Most
                                    viewed</option>
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

            {{-- Sidebar (unchanged) --}}
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
@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/quill/katex.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/highlight/highlight.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/quill/quill.js') }}"></script>
    <script src="{{ asset('assets/js/app-academy-course.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/select2/select2.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/plyr/plyr.js') }}"></script>
@endsection
@section('page-js')


    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const $form = $('#postsFilterForm');
            const $container = $('#postsContainer');
            const routeUrl = '{{ route('posts.index') }}';

            // debounce helper
            function debounce(fn, wait) {
                let t;
                return function(...args) {
                    clearTimeout(t);
                    t = setTimeout(() => fn.apply(this, args), wait);
                };
            }

            // Build a query string from form elements (returns string)
            function buildParamsFromForm() {
                const formData = $form.serializeArray();
                const params = new URLSearchParams();
                formData.forEach(({
                    name,
                    value
                }) => {
                    if (value !== null && value !== '') {
                        params.append(name, value);
                    }
                });
                return params.toString();
            }

            // Fetch partial HTML and update container; also update browser URL
            function fetchPosts(paramsString = '') {
                const url = routeUrl + (paramsString ? `?${paramsString}` : '');
                // visual loading
                $container.fadeTo(150, 0.5);
                $.ajax({
                    url: routeUrl,
                    data: paramsString,
                    method: 'GET',
                    success(html) {
                        // server returns the partial HTML for #postsContainer when AJAX request
                        $container.html(html);
                        // update browser URL (preserve other history state)
                        const newUrl = new URL(window.location.href);
                        newUrl.search = paramsString;
                        window.history.replaceState({}, '', newUrl.toString());
                        // scroll to top of list (optional)
                        window.scrollTo({
                            top: $container.offset().top - 90,
                            behavior: 'smooth'
                        });
                    },
                    error() {
                        $container.html(
                            '<div class="card"><div class="card-body text-danger">Failed to load posts. Try again.</div></div>'
                        );
                    },
                    complete() {
                        $container.fadeTo(150, 1);
                    }
                });
            }

            // Handle form submit (Filter button)
            $form.on('submit', function(e) {
                e.preventDefault();
                const params = buildParamsFromForm();
                fetchPosts(params);
            });

            // Debounced live search on input
            $('#q').on('input', debounce(function() {
                const params = buildParamsFromForm();
                fetchPosts(params);
            }, 300));

            // Handle sort/category change instantly
            $('#categoryFilter, #sortFilter').on('change', function() {
                const params = buildParamsFromForm();
                fetchPosts(params);
            });

            // Delegate pagination clicks inside container (works with partial containing links)
            $container.on('click', '.pagination a', function(e) {
                e.preventDefault();
                const href = $(this).attr('href') || '';
                if (!href) return;
                try {
                    const u = new URL(href, window.location.origin);
                    // Use the search part from pagination links (they already include query string thanks to withQueryString())
                    const params = u.searchParams.toString();
                    fetchPosts(params);
                } catch (err) {
                    // fallback: rebuild from form
                    fetchPosts(buildParamsFromForm());
                }
            });
        });
    </script>
    <Script>
        document.addEventListener('DOMContentLoaded', () => {
            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

            document
                .getElementById('postsContainer')
                .addEventListener('click', async (e) => {
                    const btn = e.target.closest('.like-button');
                    if (!btn) return;
                    e.preventDefault();

                    const postId = btn.dataset.postId;
                    const url = "{{ route('posts.like', ':post') }}".replace(':post', postId);

                    btn.disabled = true;

                    try {
                        const response = await fetch(url, {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken,
                            },
                        });

                        if (!response.ok) throw new Error('Network response was not ok');

                        const {
                            liked,
                            likes_count
                        } = await response.json();

                        // toggle heart color
                        btn.classList.toggle('liked', liked);
                        btn.classList.toggle('text-danger', liked);
                        btn.classList.toggle('text-muted', !liked);

                        // update the count in the same card
                        const card = btn.closest('.post-card');
                        const countEl = card.querySelector('.like-count');
                        if (countEl) {
                            countEl.textContent = new Intl.NumberFormat().format(likes_count);
                        }

                    } catch (err) {
                        console.error(err);
                        alert('Failed to update like. Please try again.');
                    } finally {
                        btn.disabled = false;
                    }
                });
        });
    </Script>
    <script>
        (function() {
            if (typeof Quill === 'undefined') return;
            if (!window.postQuill) {
                window.postQuill = new Quill('#post-editor', {
                    modules: {
                        toolbar: '#post-toolbar'
                    },
                    theme: 'snow'
                });
            }

            const quill = window.postQuill;
            const hiddenInput = document.getElementById('post-body');
            const form = document.getElementById('postForm');

            function updateHidden() {
                hiddenInput.value = quill.root.innerHTML;
            }
            quill.on('text-change', updateHidden);
            updateHidden();
            form.addEventListener('submit', function(e) {
                updateHidden();
                if (quill.getText().trim().length === 0) {
                    e.preventDefault();
                    alert('Content is required');
                }
            });
            window.setPostEditorContent = function(html) {
                if (!html) {
                    quill.setContents([{
                        insert: '\n'
                    }]);
                } else {
                    quill.clipboard.dangerouslyPasteHTML(html);
                }
                updateHidden();
            };

        })();
    </script>

@endsection
