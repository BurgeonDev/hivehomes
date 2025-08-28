@extends('frontend.layouts.app')
@section('title', $product->title)
@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/swiper/swiper.css') }}" />
    <style>
        #swiper-gallery .gallery-top {
            border-radius: 12px;
            overflow: hidden;
        }

        #swiper-gallery .gallery-thumbs {
            padding-top: 5px;
        }

        #swiper-gallery .gallery-thumbs .swiper-slide {
            height: 72px;
            opacity: 0.6;
            cursor: pointer;
            border-radius: 8px;
            overflow: hidden;
        }

        #swiper-gallery .gallery-thumbs .swiper-slide-thumb-active {
            opacity: 1;
            border: 2px solid #0d6efd;
        }
    </style>
@endsection
@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/ui-carousel.css') }}" />
@endsection

@php
    use Illuminate\Support\Str;
    // helper to format condition nicely
    function niceCondition($cond)
    {
        return Str::title(str_replace('_', ' ', $cond));
    }
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
                        <a href="{{ route('products.index') }}" class="text-decoration-none text-dark">Products</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">{{ Str::limit($product->title, 40) }}
                    </li>
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
                            <h1 class="mb-1 h3">{{ $product->title }}</h1>

                            <div class="mb-3 d-flex align-items-center">
                                <small class="text-muted me-3">By <strong>{{ $product->user->name }}</strong></small>
                                <small class="text-muted me-3">·
                                    {{ optional($product->created_at)->format('F j, Y') }}</small>

                                @if ($product->is_featured && $product->featured_until && $product->featured_until->isFuture())
                                    <span class="badge bg-label-warning text-capitalize ms-3">Featured</span>
                                @endif

                                <span class="badge bg-label-primary text-capitalize ms-auto">
                                    {{ $product->category->name ?? 'Uncategorized' }}
                                </span>
                            </div>
                            {{-- Images gallery with Swiper --}}
                            @php
                                $images = $product->images->sortBy('order')->values();
                            @endphp

                            @if ($images && $images->count())
                                <div id="swiper-gallery" class="mb-4">
                                    {{-- Main Gallery --}}
                                    <div class="mb-3 rounded shadow-sm swiper gallery-top">
                                        <div class="swiper-wrapper">
                                            @foreach ($images as $img)
                                                <div class="swiper-slide d-flex align-items-center justify-content-center"
                                                    style="background:#f8f9fa; height:420px;">
                                                    <img src="{{ asset('storage/' . $img->path) }}"
                                                        alt="{{ $product->title }}"
                                                        style="max-height:100%; max-width:100%; object-fit:contain;">
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="swiper-button-next"></div>
                                        <div class="swiper-button-prev"></div>
                                    </div>

                                    {{-- Thumbnail Gallery --}}
                                    <div class="swiper gallery-thumbs">
                                        <div class="swiper-wrapper">
                                            @foreach ($images as $img)
                                                <div class="swiper-slide d-flex align-items-center justify-content-center"
                                                    style="background:#f8f9fa; height:auto;">
                                                    <img src="{{ asset('storage/' . $img->path) }}"
                                                        alt="{{ $product->title }}"
                                                        style="max-height:100%; max-width:100%; object-fit:cover;">
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>

                                </div>
                            @else
                                <figure class="mb-4 rounded w-100 d-flex align-items-center justify-content-center"
                                    style="height: 420px;
           background: linear-gradient(135deg, #e0e0e0, #f5f5f5);
           color: #555;
           font-size: 1.25rem;
           font-weight: 600;
           text-align: center;">
                                    {{ $product->title }}
                                </figure>

                            @endif


                            {{-- Price & CTA --}}
                            <div class="mb-3 d-flex align-items-center">
                                <div>
                                    <h3 class="mb-1">
                                        @if (!is_null($product->price))
                                            PKR {{ number_format($product->price, 2) }}
                                        @else
                                            <span class="text-muted">Contact for price</span>
                                        @endif
                                    </h3>
                                    <div class="small text-muted">
                                        @if ($product->quantity > 0)
                                            In stock · {{ $product->quantity }} available
                                        @else
                                            <span class="text-danger">Out of stock</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="gap-2 ms-auto d-flex">
                                    @if ($product->is_negotiable)
                                        <span class="badge bg-label-success align-self-center">Negotiable</span>
                                    @endif

                                    <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#contactModal">
                                        Contact
                                    </button>



                                </div>
                            </div>

                            <hr>

                            {{-- Description --}}
                            <div class="mb-4 post-body">
                                @if ($product->description)
                                    {!! nl2br(e($product->description)) !!}
                                @else
                                    <p class="mb-0 text-muted">No description provided.</p>
                                @endif
                            </div>

                            {{-- Details cards --}}
                            <div class="mb-4 row g-3">
                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Views</small>
                                            <strong>{{ $product->views ?? 0 }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Condition</small>
                                            <strong
                                                class="text-capitalize">{{ niceCondition($product->condition) }}</strong>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="p-2 border-0 shadow-sm card h-100">
                                        <div class="p-2 text-center card-body">
                                            <small class="text-muted d-block">Status</small>
                                            <strong class="text-capitalize">{{ $product->status ?? '—' }}</strong>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            {{-- Additional metadata --}}
                            <div class="mb-3 row g-3">
                                <div class="col-md-6">
                                    <div>
                                        <small class="text-muted">Society</small>
                                        <div>{{ optional($product->society)->name ?? '—' }}</div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div>
                                        <small class="text-muted">Last updated</small>
                                        <div>{{ optional($product->updated_at)->format('F j, Y') ?? '—' }}</div>
                                    </div>
                                </div>
                            </div>

                        </div><!-- card-body -->
                    </div><!-- card -->
                </div><!-- col -->

                <!-- Sidebar -->
                <div class="col-lg-4">
                    <div class="position-sticky" style="top: 95px;">

                        {{-- Seller / Profile Card --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="text-center card-body">
                                @if (!empty($product->user->profile_pic))
                                    <img src="{{ asset('storage/' . $product->user->profile_pic) }}"
                                        alt="{{ $product->user->name }}" class="mb-2 rounded-circle" width="80"
                                        height="80" style="object-fit:cover;">
                                @else
                                    <div class="mb-2 text-white avatar avatar-lg bg-primary rounded-circle d-inline-flex align-items-center justify-content-center"
                                        style="width:80px;height:80px;">
                                        {{ strtoupper(substr($product->user->name, 0, 1)) }}
                                    </div>
                                @endif

                                <h6 class="mb-0">{{ $product->user->name }}</h6>
                                <small
                                    class="badge bg-label-primary">{{ $product->user->getRoleNames()->first() ?? 'User' }}</small>

                                <div class="mt-3">
                                    <a href="{{ route('products.index', ['author' => $product->user->id]) }}"
                                        class="mb-2 btn btn-sm btn-outline-primary w-100">More by seller</a>
                                    <button type="button" class="btn btn-sm btn-primary w-100" data-bs-toggle="modal"
                                        data-bs-target="#contactModal">
                                        Contact
                                    </button>

                                </div>
                            </div>
                        </div>

                        {{-- Quick info --}}
                        <div class="mb-3 shadow-sm card">
                            <div class="card-body">
                                <h6 class="mb-3">Quick Info</h6>
                                <div class="row g-2 small">

                                    <div class="col-6">
                                        <div
                                            class="p-2 rounded bg-label-primary d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Posted</small>
                                            <strong>{{ optional($product->created_at)->format('F j, Y') }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div
                                            class="p-2 rounded bg-label-info d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Category</small>
                                            <strong>{{ $product->category->name ?? '—' }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div
                                            class="p-2 rounded bg-label-success d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Quantity</small>
                                            <strong>{{ $product->quantity }}</strong>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div
                                            class="p-2 rounded bg-label-warning d-flex justify-content-between align-items-center">
                                            <small class="text-muted">Negotiable</small>
                                            <strong>{{ $product->is_negotiable ? 'Yes' : 'No' }}</strong>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>


                        {{-- Related products --}}
                        @php
                            $related = \App\Models\Product::where('category_id', $product->category_id)->where(
                                'id',
                                '!=',
                                $product->id,
                            );
                            if ($related) {
                                $related = $related->latest()->take(4)->get();
                            } else {
                                $related = \App\Models\Product::where('category_id', $product->category_id)
                                    ->where('id', '!=', $product->id)
                                    ->latest()
                                    ->take(4)
                                    ->get();
                            }
                        @endphp

                        @if ($related->count())
                            <div class="mb-3 shadow-sm card">
                                <div class="card-body">
                                    <h6 class="mb-3">Related Products</h6>
                                    <ul class="list-unstyled">
                                        @foreach ($related as $r)
                                            <li class="mb-2 d-flex">
                                                @php $thumb = $r->images->sortBy('order')->first(); @endphp
                                                <div style="width:56px; height:56px; overflow:hidden; border-radius:6px; background:#f8f9fa;"
                                                    class="d-flex align-items-center justify-content-center">
                                                    @if ($thumb)
                                                        <img src="{{ asset('storage/' . $thumb->path) }}" alt=""
                                                            style="max-width:100%; max-height:100%; object-fit:contain;">
                                                    @else
                                                        <img src="{{ asset('assets/img/placeholder-sm.png') }}"
                                                            alt=""
                                                            style="max-width:100%; max-height:100%; object-fit:contain;">
                                                    @endif
                                                </div>


                                                <div class="ms-2">
                                                    <a href="{{ route('products.show', $r->id) }}"
                                                        class="text-decoration-none">
                                                        {{ Str::limit($r->title, 60) }}
                                                        <br><small class="text-muted">
                                                            {{ is_null($r->price) ? 'Contact' : 'PKR ' . number_format($r->price, 2) }}
                                                        </small>
                                                    </a>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <a href="{{ route('products.index', ['category' => $product->category_id]) }}"
                                        class="btn btn-sm btn-outline-primary w-100">See more</a>
                                </div>
                            </div>
                        @endif

                    </div> {{-- sticky --}}
                </div>
            </div>
        </div>
        <!-- Contact Modal -->
        <div class="modal fade" id="contactModal" tabindex="-1" aria-labelledby="contactModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="contactModalLabel">Seller Contact Info</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <ul class="mb-0 list-unstyled">
                            <li><strong>Name:</strong> {{ $product->user->name }}</li>
                            <li><strong>Email:</strong> {{ $product->user->email }}</li>
                            <li><strong>Phone:</strong> {{ $product->user->phone ?? 'Not provided' }}</li>
                            <li><strong>Society:</strong> {{ optional($product->society)->name ?? '—' }}</li>
                        </ul>
                    </div>

                    <div class="modal-footer">

                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>

                </div>
            </div>
        </div>
    </section>


@endsection
@section('page-js')
    <script src="{{ asset('assets/js/ui-carousel.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var galleryThumbs = new Swiper('.gallery-thumbs', {
                spaceBetween: 10,
                slidesPerView: 5,
                freeMode: true,
                watchSlidesProgress: true,
            });
            var galleryTop = new Swiper('.gallery-top', {
                spaceBetween: 10,
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                thumbs: {
                    swiper: galleryThumbs
                }
            });
        });
    </script>

@endsection
@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/swiper/swiper.js') }}"></script>
@endsection
