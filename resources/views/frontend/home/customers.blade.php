<section id="landingProducts" class="pb-0 section-py bg-body landing-products">
    <div class="container">
        <div class="mb-5 row align-items-center gx-0 gy-4 g-lg-5 pb-md-5">
            <div class="col-md-6 col-lg-5 col-xl-3">
                <div class="mb-4">
                    <span class="badge bg-label-primary">Latest Products</span>
                </div>
                <h4 class="mb-1">
                    <span class="position-relative fw-extrabold z-1">Products for Sale
                        <img src="{{ asset('assets/img/front-pages/icons/section-title-icon.png') }}" alt="products"
                            class="bottom-0 section-title-img position-absolute object-fit-contain z-n1" />
                    </span>
                </h4>
                <p class="mb-5 mb-md-12">
                    Explore the latest products available<br class="d-none d-xl-block" />
                    in our marketplace today.
                </p>
                <div>
                    <a href="{{ route('products.index') }}" class="btn btn-label-primary">
                        See More
                    </a>
                </div>
            </div>

            <div class="col-md-6 col-lg-7 col-xl-9">
                <div class="row g-4">
                    @php
                        $query = \App\Models\Product::where('status', 'approved');

                        if (auth()->check()) {
                            $user = auth()->user();

                            if ($user->hasRole('society_admin') || $user->hasRole('member')) {
                                $query->where('society_id', $user->society_id);
                            }
                        }

                        $products = $query->latest()->take(8)->get();
                    @endphp


                    @forelse ($products as $product)
                        @php
                            $primaryImage = \App\Models\ProductImage::where('product_id', $product->id)
                                ->where('is_primary', 1)
                                ->first();
                            $imagePath = $primaryImage
                                ? asset('storage/' . $primaryImage->path)
                                : asset('assets/img/front-pages/placeholder.png');
                        @endphp

                        <div class="col-sm-6 col-md-4 col-lg-3">
                            <div class="shadow-sm rounded-4 card h-100">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                        alt="{{ $product->title }}" class="product-media w-100">
                                @else
                                    <div class="no-image-placeholder">No Image</div>
                                @endif

                                <div class="card-body d-flex flex-column justify-content-between">
                                    <h6 class="mb-2 fw-bold text-truncate">{{ $product->title }}</h6>
                                    <p class="mb-2 small text-muted text-truncate">{{ $product->description }}</p>
                                    <div class="mb-3 fw-bold text-primary">Rs. {{ number_format($product->price, 2) }}
                                    </div>

                                    <div class="mt-auto d-flex justify-content-between align-items-center">
                                        <span
                                            class="badge bg-label-info text-capitalize">{{ $product->condition }}</span>
                                        <a href="{{ route('products.show', $product->id) }}"
                                            class="btn btn-sm btn-outline-primary">
                                            View
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p>No products available right now.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
    <hr class="m-0 mt-6 mt-md-12" />
</section>
