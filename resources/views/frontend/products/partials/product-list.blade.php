<div id="productsContainer">
    <div class="row gy-4">
        @forelse($products as $product)
            <div class="col-md-6">
                <div class="card product-card h-100 d-flex flex-column">
                    <div class="row g-0">
                        <div class="col-5">
                            <a href="{{ route('products.show', $product) }}" class="d-block h-100">
                                @if ($product->primaryImage)
                                    <img src="{{ asset('storage/' . $product->primaryImage->path) }}"
                                        alt="{{ $product->title }}" class="product-media">
                                @else
                                    <div class="no-image-placeholder">
                                        <div>No Image</div>
                                    </div>
                                @endif
                            </a>
                        </div>

                        <div class="col-7">
                            <div class="card-body d-flex flex-column h-100">
                                <div class="mb-2">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <h6 class="mb-1">
                                            <a href="{{ route('products.show', $product) }}"
                                                class="text-dark text-decoration-none">
                                                {{ Str::limit($product->title, 80) }}
                                            </a>
                                        </h6>

                                        <div class="d-flex flex-column align-items-end">
                                            {{-- featured badge --}}
                                            @if ($product->is_featured)
                                                <span class="text-white product-badge bg-label-warning">Featured</span>
                                                @if ($product->featured_until)
                                                    <small
                                                        class="text-muted d-block">{{ \Carbon\Carbon::parse($product->featured_until)->diffForHumans() }}</small>
                                                @endif
                                            @endif

                                            {{-- status for admins --}}
                                            @if (auth()->user() && (isset($isSuperAdmin) && $isSuperAdmin))
                                                <small class="muted-very">#{{ $product->id }} · <span
                                                        class="text-capitalize">{{ $product->status }}</span></small>
                                            @endif
                                        </div>
                                    </div>

                                    <p class="mb-1 small text-muted">
                                        <strong class="text-dark">₨
                                            {{ $product->price !== null ? number_format($product->price, 2) : 'N/A' }}</strong>
                                        &middot; <span
                                            class="text-white badge bg-label-info product-badge text-capitalize">{{ str_replace('_', ' ', $product->condition) }}</span>
                                        @if ($product->is_negotiable)
                                            &middot; <span
                                                class="text-white badge bg-label-success product-badge">Negotiable</span>
                                        @endif
                                    </p>

                                    <p class="mb-2 seller-meta">
                                        @if ($product->seller)
                                            <span class="muted-very">{{ $product->seller->name }}</span> &middot;
                                        @endif
                                        @if ($product->society)
                                            <span class="muted-very">{{ $product->society->name }}</span> &middot;
                                        @endif
                                        <span class="muted-very">{{ $product->created_at->format('d M, Y') }}</span>
                                    </p>

                                    <p class="mb-2 small text-muted">{{ Str::limit($product->description ?? '', 110) }}
                                    </p>

                                    {{-- meta pill row --}}
                                    <div class="mb-2 label-row">
                                        <span class="text-white meta-pill bg-label-secondary">Qty:
                                            {{ $product->quantity }}</span>
                                        <span class="text-white meta-pill bg-label-primary">Views:
                                            {{ number_format($product->views ?? 0) }}</span>
                                        <span class="text-white meta-pill bg-label-info">Category:
                                            {{ $product->category ? $product->category->name : '—' }}</span>
                                        @if ($product->updated_at && $product->updated_at->gt($product->created_at))
                                            <span class="meta-pill bg-label-light text-dark">Updated</span>
                                        @endif
                                    </div>
                                </div>

                                <div class="mt-auto">
                                    <div class="gap-2 d-flex">
                                        <a href="{{ route('products.show', $product) }}"
                                            class="btn btn-sm rounded-pill btn-outline-primary w-50">
                                            <i class="ti tabler-eye me-1"></i> View
                                        </a>

                                        {{-- contact seller (rounded-pill, labeled) --}}
                                        @if ($product->seller_id)
                                            <a href="{{ route('messages.create', ['to' => $product->seller_id]) }}"
                                                class="btn btn-sm rounded-pill btn-primary btn-contact-seller w-50 bg-label-success">
                                                <i class="ti tabler-message me-1"></i> Contact
                                            </a>
                                        @else
                                            <a href="{{ route('products.show', $product) }}"
                                                class="btn btn-sm rounded-pill btn-primary w-50 bg-label-success">
                                                <i class="ti tabler-info me-1"></i> Details
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-footer">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small text-muted">ID: {{ $product->id }} · Status: <span
                                    class="text-capitalize">{{ $product->status }}</span></div>
                            <div>
                                {{-- optional quick actions for owner / admin --}}
                                @if (auth()->user() && (auth()->id() == $product->user_id || (isset($isSuperAdmin) && $isSuperAdmin)))
                                    <a href="{{ route('products.edit', $product) }}"
                                        class="small text-decoration-none me-3">Edit</a>
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

    {{-- Pagination (visible) --}}
    <div class="mt-4 d-flex justify-content-center">
        {{ $products->links('pagination::bootstrap-5') }}
    </div>
</div>
