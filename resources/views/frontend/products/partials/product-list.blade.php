<div id="productsContainer">
    <div class="row gy-4">
        @forelse($products as $product)
            <div class="col-md-6">
                <div class="card product-card h-100 d-flex flex-column">
                    <div class="row g-0">
                        {{-- Image Column --}}
                        <div class="col-6">
                            <a href="{{ route('products.show', $product) }}" class="d-block h-100">
                                <div class="product-image-wrap">
                                    @if ($product->primaryImage)
                                        <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                            alt="{{ $product->title }}" class="product-media w-100">
                                    @else
                                        <div class="no-image-placeholder">No Image</div>
                                    @endif

                                    {{-- Category badge on image (solid look) --}}
                                    @if ($product->category)
                                        <span class="badge bg-label-primary text-white product-cat-badge">
                                            {{ $product->category->name }}
                                        </span>
                                    @endif

                                    {{-- Featured small badge (top-right) --}}
                                    @if ($product->is_featured)
                                        <span
                                            class="badge bg-label-warning text-dark product-featured-badge">Featured</span>
                                    @endif
                                </div>
                            </a>
                        </div>

                        {{-- Content Column --}}
                        <div class="col-6">
                            <div class="card-body d-flex flex-column h-100">
                                <div>
                                    <div class="d-flex justify-content-between align-items-start mb-1">
                                        <h6 class="product-title mb-1">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="text-dark text-decoration-none">
                                                {{ Str::limit($product->title, 80) }}
                                            </a>
                                        </h6>
                                    </div>

                                    <p class="mb-1">
                                        <strong class="text-dark">₨
                                            {{ $product->price !== null ? number_format($product->price, 2) : 'N/A' }}</strong>
                                        &nbsp;&middot;&nbsp;
                                        <span
                                            class="badge bg-label-info text-white text-capitalize">{{ str_replace('_', ' ', $product->condition) }}</span>

                                        @if ($product->is_negotiable)
                                            &nbsp;&middot;&nbsp;<span
                                                class="badge bg-label-success text-white rounded-pill">Negotiable</span>
                                        @endif
                                    </p>

                                    <p class="mb-2 small-muted">
                                        @if ($product->seller)
                                            {{ $product->seller->name }} &middot;
                                        @endif
                                        @if ($product->society)
                                            {{ $product->society->name }} &middot;
                                        @endif
                                        {{ $product->created_at->format('d M, Y') }}
                                    </p>

                                    <p class="mb-2 small text-muted">{{ Str::limit($product->description ?? '', 110) }}
                                    </p>

                                    <div class="mb-2">
                                        <span class="meta-pill bg-label-secondary text-white">Qty:
                                            {{ $product->quantity }}</span>
                                        <span class="meta-pill bg-label-primary text-white">Views:
                                            {{ number_format($product->views ?? 0) }}</span>
                                    </div>
                                </div>

                                {{-- Action buttons --}}
                                <div class="mt-auto d-flex gap-2">
                                    <a href="{{ route('products.show', $product) }}"
                                        class="btn btn-sm rounded-pill btn-outline-primary w-50">
                                        <i class="ti tabler-eye me-1"></i> View
                                    </a>

                                    @if ($product->seller_id)
                                        <a href="{{ route('messages.create', ['to' => $product->seller_id]) }}"
                                            class="btn btn-sm rounded-pill bg-label-success text-white w-50">
                                            <i class="ti tabler-message me-1"></i> Contact
                                        </a>
                                    @else
                                        <a href="{{ route('products.show', $product) }}"
                                            class="btn btn-sm rounded-pill bg-label-success text-white w-50">
                                            <i class="ti tabler-info me-1"></i> Details
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Footer with owner-only Edit --}}
                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-muted">Status: <span
                                    class="text-capitalize ms-1">{{ $product->status }}</span></div>

                            <div class="d-flex align-items-center">
                                @if (auth()->check() && auth()->id() == $product->user_id)
                                    @php
                                        $productPayload = [
                                            'id' => $product->id,
                                            'title' => $product->title,
                                            'description' => $product->description,
                                            'category_id' => $product->category_id,
                                            'price' => $product->price,
                                            'quantity' => $product->quantity,
                                            'condition' => $product->condition,
                                            'is_negotiable' => (int) $product->is_negotiable,
                                            'is_featured' => (int) $product->is_featured,
                                        ];
                                    @endphp

                                    <button class="small btn btn-outline-secondary btn-sm me-3 btn-open-edit-product"
                                        type="button" data-product='@json($productPayload)'>
                                        <i class="ti tabler-pencil me-1"></i> Edit
                                    </button>
                                @endif

                                <span class="small text-muted">{{ $product->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="mb-0 alert alert-info">No products found.</div>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
