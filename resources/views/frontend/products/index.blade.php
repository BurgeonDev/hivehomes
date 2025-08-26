@extends('frontend.layouts.app')
@section('title', 'Products')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <style>
        /* modern product marketplace styles */
        .product-card {
            border: 0;
            box-shadow: 0 8px 30px rgba(15, 20, 40, 0.06);
            border-radius: 14px;
            overflow: hidden;
        }

        .product-card .card-body {
            padding: 0.85rem 1rem;
        }

        .product-media {
            height: 140px;
            width: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: 14px;
            border-bottom-left-radius: 14px;
        }

        .product-badge {
            font-size: .72rem;
            padding: .22rem .5rem;
            border-radius: 999px;
        }

        .kpi-card {
            padding: .8rem 1rem;
            border-radius: 12px;
            min-width: 170px;
        }

        .filter-card {
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(32, 32, 80, 0.04);
        }

        .no-image-placeholder {
            height: 140px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, #adb5bd, #6c757d);
        }

        .seller-meta {
            font-size: .82rem;
            color: #6b7280;
        }

        .product-cta {
            gap: .6rem;
            display: flex;
            align-items: center;
        }

        .meta-pill {
            font-size: .77rem;
            padding: .25rem .6rem;
            border-radius: 999px;
            display: inline-block;
        }

        .muted-very {
            color: #6b7280;
            font-size: .88rem;
        }

        .label-row {
            gap: .5rem;
            display: flex;
            flex-wrap: wrap;
            align-items: center;
        }

        .card .card-footer {
            background: transparent;
            border-top: 1px dashed rgba(0, 0, 0, 0.04);
        }
    </style>
@endsection

@section('content')
    <section class="overflow-hidden section-py first-section-pt" style="min-height:200px; background:#f8f9fa;">
        <div class="container py-4 text-center">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-decoration-none">Home</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            {{-- Left: Products List --}}
            <div class="col-lg-8">
                {{-- KPI & Actions --}}
                <div class="mb-4 d-flex align-items-center justify-content-between">
                    <div class="gap-3 d-flex align-items-center">
                        <div>
                            <h4 class="mb-0">Products</h4>
                            <small class="text-muted">Approved items listed by members</small>
                        </div>

                        <div class="text-center shadow-sm kpi-card bg-label-primary">
                            <div class="small text-white-50">Total</div>
                            <div class="mb-0 text-white h4">{{ number_format($products->total()) }}</div>
                        </div>

                        <div class="text-center shadow-sm kpi-card bg-label-info">
                            <div class="small text-white-50">Categories</div>
                            <div class="mb-0 text-white h5">{{ number_format($categories->count()) }}</div>
                        </div>
                    </div>

                    <div class="gap-2 d-flex align-items-center">
                        {{-- Add Product rounded-pill --}}
                        @can('create', App\Models\Product::class)
                            <a href="{{ route('products.create') }}" class="btn rounded-pill btn-primary bg-label-success">
                                <i class="ti tabler-plus me-1"></i> Add Product
                            </a>
                        @endcan

                        @if (!empty($isSuperAdmin) && $isSuperAdmin)
                            <span class="badge bg-label-warning rounded-pill">Super Admin — viewing all societies</span>
                        @endif
                    </div>
                </div>

                {{-- Products container (AJAX swaps this) --}}
                <div id="productsContainer" class="mb-4">
                    @include('frontend.products.partials.product-list', ['products' => $products])
                </div>
            </div>

            {{-- Right: Filters Sidebar --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top:95px;">
                    <div class="p-3 mb-3 card filter-card">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="small muted-very">Filters</div>
                            <div>
                                <button id="resetFilters" type="button"
                                    class="btn btn-sm btn-outline-secondary rounded-pill">Reset</button>
                            </div>
                        </div>
                    </div>

                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <form id="landingFilterForm" autocomplete="off">
                                <div class="mb-3">
                                    <input type="search" name="search" id="filterSearch"
                                        class="form-control form-control-sm" placeholder="Search products… (title, desc)"
                                        value="{{ request('search') }}">
                                </div>

                                <div class="mb-3">
                                    <select name="sort" id="filterSort" class="mb-3 form-select form-select-sm">
                                        <option value="latest"
                                            {{ request('sort', 'latest') == 'latest' ? 'selected' : '' }}>
                                            Newest</option>
                                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>
                                            Price
                                            ↑</option>
                                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>
                                            Price ↓</option>
                                        <option value="alpha" {{ request('sort') == 'alpha' ? 'selected' : '' }}>A to Z
                                        </option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <select name="category_id" id="filterCategory" class="mb-3 form-select form-select-sm">
                                        <option value="">All Categories</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}"
                                                {{ request('category_id') == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="gap-2 mb-3 d-flex">
                                    <input type="number" name="price_min" id="filterMin"
                                        class="form-control form-control-sm" placeholder="Min"
                                        value="{{ request('price_min') }}">
                                    <input type="number" name="price_max" id="filterMax"
                                        class="form-control form-control-sm" placeholder="Max"
                                        value="{{ request('price_max') }}">
                                </div>

                                <div class="mb-3">
                                    <select name="condition" id="filterCondition" class="form-select form-select-sm">
                                        <option value="">Any Condition</option>
                                        <option value="new" {{ request('condition') == 'new' ? 'selected' : '' }}>New
                                        </option>
                                        <option value="like_new"
                                            {{ request('condition') == 'like_new' ? 'selected' : '' }}>
                                            Like New</option>
                                        <option value="used" {{ request('condition') == 'used' ? 'selected' : '' }}>Used
                                        </option>
                                        <option value="refurbished"
                                            {{ request('condition') == 'refurbished' ? 'selected' : '' }}>Refurbished
                                        </option>
                                        <option value="other" {{ request('condition') == 'other' ? 'selected' : '' }}>
                                            Other
                                        </option>
                                    </select>
                                </div>

                                <div class="gap-2 mb-3 d-flex align-items-center">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="filterNegotiable"
                                            name="is_negotiable" value="1"
                                            {{ request('is_negotiable') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label small muted-very" for="filterNegotiable">Only
                                            Negotiable</label>
                                    </div>

                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" id="filterFeatured"
                                            name="is_featured" value="1"
                                            {{ request('is_featured') == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label small muted-very" for="filterFeatured">Featured
                                            only</label>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <select name="per_page" id="filterPerPage" class="form-select form-select-sm">
                                        <option value="6" {{ request('per_page') == '6' ? 'selected' : '' }}>Show 6
                                        </option>
                                        <option value="12" {{ request('per_page', 12) == '12' ? 'selected' : '' }}>
                                            Show
                                            12</option>
                                        <option value="24" {{ request('per_page') == '24' ? 'selected' : '' }}>Show 24
                                        </option>
                                        <option value="48" {{ request('per_page') == '48' ? 'selected' : '' }}>Show 48
                                        </option>
                                    </select>
                                </div>

                                {{-- NOTE: Apply button removed: filters run automatically on input/change --}}
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        (function() {
            const form = document.getElementById('landingFilterForm');
            const resetBtn = document.getElementById('resetFilters');
            const container = document.getElementById('productsContainer');
            let timeout;

            const getFilters = () => {
                const data = {};
                // inputs to capture
                ['filterSearch', 'filterSort', 'filterCategory', 'filterMin', 'filterMax', 'filterCondition',
                    'filterPerPage', 'filterNegotiable', 'filterFeatured'
                ].forEach(id => {
                    const el = document.getElementById(id);
                    if (!el) return;
                    // switches/checkboxes
                    if (el.type === 'checkbox') {
                        if (el.checked) data[el.name] = el.value;
                    } else {
                        if (el.value !== null && el.value !== '') data[el.name] = el.value;
                    }
                });
                return data;
            };

            const buildUrl = (params) => {
                const url = new URL(window.location.href);
                url.search = new URLSearchParams(params).toString();
                return url.toString();
            };

            const injectHtml = (html) => {
                const temp = document.createElement('div');
                temp.innerHTML = html;
                const newWrapper = temp.querySelector('#productsContainer');
                if (newWrapper) {
                    container.innerHTML = newWrapper.innerHTML;
                } else {
                    container.innerHTML = html;
                }
            };

            const fetchProducts = (page = null, replaceState = true) => {
                clearTimeout(timeout);
                timeout = setTimeout(() => {
                    const params = getFilters();
                    if (page) params.page = page;
                    const query = new URLSearchParams(params).toString();
                    const url = `{{ route('products.index') }}?${query}`;

                    fetch(url, {
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest'
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Network response was not ok');
                            return res.text();
                        })
                        .then(html => {
                            injectHtml(html);
                            if (replaceState) history.pushState(params, '', buildUrl(params));
                            attachPaginationHandlers();
                        })
                        .catch(err => {
                            console.error('Product load failed', err);
                        });
                }, 250); // debounce
            };

            // live filtering: input and change (no apply button)
            ['input', 'change'].forEach(evt => {
                form.querySelectorAll('input, select').forEach(el => {
                    el.addEventListener(evt, () => fetchProducts(1));
                });
            });

            // reset
            resetBtn.addEventListener('click', () => {
                form.reset();
                // ensure checkboxes become unchecked
                document.getElementById('filterNegotiable').checked = false;
                document.getElementById('filterFeatured').checked = false;
                fetchProducts(1);
            });

            // pagination delegation inside injected HTML
            const attachPaginationHandlers = () => {
                container.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', (e) => {
                        e.preventDefault();
                        const href = link.getAttribute('href');
                        if (!href) return;
                        const url = new URL(href, window.location.origin);
                        const page = url.searchParams.get('page') || 1;
                        fetchProducts(page);
                    });
                });

                // optional: attach any quick-action contact buttons inside injected HTML
                container.querySelectorAll('.btn-contact-seller').forEach(btn => {
                    btn.addEventListener('click', (e) => {
                        // example noop — ensure these exist in partial
                    });
                });
            };

            // back/forward
            window.addEventListener('popstate', () => {
                const params = new URLSearchParams(window.location.search);
                // map back to form
                const map = {
                    search: 'filterSearch',
                    sort: 'filterSort',
                    category_id: 'filterCategory',
                    price_min: 'filterMin',
                    price_max: 'filterMax',
                    condition: 'filterCondition',
                    per_page: 'filterPerPage',
                    is_negotiable: 'filterNegotiable',
                    is_featured: 'filterFeatured'
                };
                Object.keys(map).forEach(k => {
                    const el = document.getElementById(map[k]);
                    if (!el) return;
                    const val = params.get(k);
                    if (el.type === 'checkbox') {
                        el.checked = val === '1';
                    } else {
                        el.value = val || '';
                    }
                });
                fetchProducts(params.get('page') || 1, false);
            });

            // initial attach
            attachPaginationHandlers();
        })();
    </script>
@endpush
