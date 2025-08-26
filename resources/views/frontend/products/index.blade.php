@extends('frontend.layouts.app')
@section('title', 'Products')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">
    <style>
        /* --- Card / Filter visuals (adapted from Service Providers) --- */
        .filter-card {
            border-radius: .6rem;
            overflow: hidden;
            box-shadow: 0 6px 18px rgba(3, 10, 18, 0.03);
        }

        .filter-card .card-body {
            padding: .8rem;
        }

        .list-group-item {
            padding: .45rem .75rem;
            font-size: .92rem;
        }

        .list-group-item .badge {
            font-size: .78rem;
            padding: .25rem .45rem;
            border-radius: .45rem;
        }

        .product-card {
            border-radius: .5rem;
            transition: box-shadow .28s ease;
        }

        .product-card:hover {
            box-shadow: 0 8px 22px rgba(17, 24, 39, 0.06);
        }

        .kpi-card {
            border-radius: .6rem;
            padding: .85rem;
        }

        #productsFilterForm .form-control {
            height: 38px;
            font-size: .92rem;
            padding: .35rem .6rem;
            border-radius: .45rem;
        }

        #productsFilterForm .btn {
            height: 36px;
            padding: .25rem .7rem;
            font-size: .88rem;
            border-radius: .45rem;
        }

        .filters-top-toolbar {
            display: flex;
            gap: .5rem;
            align-items: center;
            justify-content: space-between;
            padding: .6rem .75rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, .98), rgba(250, 250, 250, .98));
            border-bottom: 1px solid rgba(0, 0, 0, .03);
        }

        .rating-clickable {
            cursor: pointer;
            gap: .5rem;
            padding: .25rem 0;
            align-items: center;
            font-size: .86rem;
        }

        .rating-clickable .progress {
            height: 6px;
            margin: 0 .6rem;
            border-radius: 999px;
            background: rgba(13, 110, 253, 0.06);
            flex: 1;
            overflow: hidden;
        }

        .rating-clickable .progress-bar {
            box-shadow: none;
            transition: width .35s ease;
        }

        .rating-clickable .w-px-20 {
            width: 40px;
            text-align: right;
            font-size: .82rem;
        }

        .filter-card .list-group-item.active {
            background-color: rgba(13, 110, 253, 0.06);
            border-color: rgba(13, 110, 253, 0.12);
        }

        .position-sticky {
            top: 95px;
        }

        @media (max-width:991px) {
            .position-sticky {
                position: static;
                top: auto;
            }
        }

        .product-media {
            height: 140px;
            width: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: .5rem;
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

        /* Card visuals for product grid */
        .product-card {
            border-radius: .75rem;
            overflow: hidden;
            box-shadow: 0 8px 30px rgba(12, 20, 40, 0.06);
        }

        .product-media {
            height: 180px;
            width: 100%;
            object-fit: cover;
            display: block;
            border-top-left-radius: .75rem;
        }

        .product-image-wrap {
            position: relative;
            overflow: hidden;
            height: 180px;
        }

        .product-cat-badge {
            position: absolute;
            left: 12px;
            top: 12px;
            z-index: 5;
            font-size: .78rem;
            padding: .35rem .6rem;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(12, 20, 40, 0.08);
        }

        .product-featured-badge {
            position: absolute;
            right: 12px;
            top: 12px;
            z-index: 5;
            font-size: .75rem;
            padding: .28rem .45rem;
            border-radius: 999px;
            box-shadow: 0 6px 18px rgba(12, 20, 40, 0.08);
        }

        .no-image-placeholder {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, #adb5bd, #6c757d);
        }

        .meta-pill {
            font-size: .78rem;
            padding: .28rem .6rem;
            border-radius: 999px;
            display: inline-block;
            margin-right: .4rem;
        }

        .product-title {
            font-weight: 600;
            font-size: 1rem;
            line-height: 1.1;
        }

        .product-card .card-body {
            padding: .9rem;
        }

        .product-card .card-footer {
            background: transparent;
            border-top: 1px dashed rgba(0, 0, 0, 0.04);
            padding: .55rem .9rem;
        }

        .small-muted {
            color: #6b7280;
            font-size: .85rem;
        }
    </style>
@endsection

@section('content')
    {{-- Banner / Breadcrumb (visual) --}}
    <section class="overflow-hidden section-py first-section-pt position-relative" style="min-height:240px;">
        <div class="container py-4 text-center">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}"
                            class="text-decoration-none text-primary">Home</a></li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Products</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            {{-- Left: Products List --}}
            <div class="col-lg-9">
                <!-- Products KPI Card -->
                <div class="mb-4 card">
                    <div class="gap-3 card-body d-flex flex-column flex-md-row align-items-start">
                        <div class="flex-grow-1">
                            <h4 class="mb-1">Products</h4>
                            <p class="mb-0 text-muted">Approved items listed by members</p>
                        </div>
                        <div class="gap-2 d-flex align-items-center">
                            <button type="button" class="btn btn-label-primary waves-effect">
                                Total Products
                                <span
                                    class="text-white badge bg-primary badge-center ms-1">{{ number_format($approvedCount ?? 0) }}</span>
                            </button>

                            <div class="ms-2">
                                <button id="btnAddProduct" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#productModal">
                                    <i class="menu-icon icon-base ti tabler-plus me-1"></i> Add Product
                                </button>
                                @include('frontend.products.partials.product-modal')
                            </div>
                        </div>
                    </div>
                </div>


                {{-- Products List (AJAX) --}}
                <div id="productsContainer">
                    @include('frontend.products.partials.product-list', ['products' => $products])
                </div>
            </div>

            {{-- Right: Filters Sidebar --}}
            <div class="col-lg-3">
                <div class="position-sticky" style="top:95px;">

                    {{-- Top toolbar with Reset --}}
                    <div class="mb-3 card filter-card">
                        <div class="filters-top-toolbar">
                            <div class="small text-muted">Filters</div>
                            <div class="reset-wrap">
                                <button id="resetFilters" type="button"
                                    class="btn btn-sm btn-outline-secondary rounded-pill">Reset</button>
                            </div>
                        </div>
                    </div>

                    {{-- Search --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Search</h6>
                            <form id="productsFilterForm" class="d-flex" action="javascript:void(0)" method="GET">
                                <input type="search" name="search" class="form-control form-control-sm me-2"
                                    placeholder="Search title or description…" value="{{ request('search') }}" />
                            </form>
                        </div>
                    </div>

                    {{-- Sort --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Sort By</h6>
                            <select name="sort" class="form-select form-select-sm" id="sortFilter">
                                <option value="latest" {{ request('sort', 'latest') === 'latest' ? 'selected' : '' }}>Newest
                                </option>
                                <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low
                                    →
                                    High</option>
                                <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price:
                                    High → Low</option>
                                <option value="alpha" {{ request('sort') === 'alpha' ? 'selected' : '' }}>A → Z</option>
                            </select>
                        </div>
                    </div>

                    {{-- Categories (type-like list) --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Categories</h6>
                            <ul id="categoriesList" class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between {{ request()->filled('category_id') ? '' : 'active' }}"
                                    data-cat="">
                                    <span>All</span>
                                    <span class="badge bg-label-secondary">{{ number_format($products->total()) }}</span>
                                </li>
                                @foreach ($categories as $cat)
                                    <li class="list-group-item d-flex justify-content-between {{ request('category_id') == $cat->id ? 'active' : '' }}"
                                        data-cat="{{ $cat->id }}">
                                        <span>{{ $cat->name }}</span>
                                        {{-- quick count (simple) --}}
                                        <span class="badge bg-label-secondary">
                                            {{ number_format($cat->products()->where('status', 'approved')->count()) }}
                                        </span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>

                    {{-- Condition Distribution (like rating) --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body" id="conditionList">
                            <h6 class="mb-3">Condition</h6>
                            @php $selectedCondition = request('condition') ? request('condition') : null; @endphp

                            @php
                                $conditions = [
                                    'new' => 'New',
                                    'like_new' => 'Like New',
                                    'used' => 'Used',
                                    'refurbished' => 'Refurbished',
                                    'other' => 'Other',
                                ];
                            @endphp

                            @foreach ($conditions as $key => $label)
                                @php
                                    $count = \App\Models\Product::where('condition', $key)
                                        ->where('status', 'approved')
                                        ->when(!(isset($isSuperAdmin) && $isSuperAdmin), function ($q) {
                                            $q->where('society_id', auth()->user()->society_id);
                                        })
                                        ->count();
                                    $percent = $products->total() ? round(($count / $products->total()) * 100) : 0;
                                @endphp

                                <div class="gap-2 mb-1 d-flex align-items-center rating-clickable {{ $selectedCondition === $key ? 'active' : '' }}"
                                    data-condition="{{ $key }}">
                                    <small>{{ $label }}</small>
                                    <div class="mx-2 progress w-100 bg-label-primary">
                                        <div class="progress-bar bg-label-primary" role="progressbar"
                                            style="width: {{ $percent }}%" aria-valuenow="{{ $count }}"
                                            aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <small class="w-px-20 text-end">{{ $count }}</small>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- Toggles + per page --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
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
                                    <option value="12" {{ request('per_page', 12) == '12' ? 'selected' : '' }}>Show 12
                                    </option>
                                    <option value="24" {{ request('per_page') == '24' ? 'selected' : '' }}>Show 24
                                    </option>
                                </select>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
@section('vendor-js')
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
@endsection
@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('productsContainer');
            const form = document.getElementById('productsFilterForm');
            const sortSel = document.getElementById('sortFilter');
            const categoriesList = document.getElementById('categoriesList');
            const conditionList = document.getElementById('conditionList');
            const resetBtn = document.getElementById('resetFilters');
            const routeUrl = '{{ route('products.index') }}';

            let selectedCategory = '{{ request('category_id', '') }}' || '';
            let selectedCondition = '{{ request('condition', '') }}' || '';

            function debounce(fn, wait) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), wait);
                };
            }

            function buildParams(page = null) {
                const s = (form.querySelector('[name=search]') || {
                    value: ''
                }).value || '';
                const sort = (sortSel && sortSel.value) || 'latest';
                const per_page = (document.getElementById('filterPerPage') && document.getElementById(
                    'filterPerPage').value) || '';
                const is_neg = (document.getElementById('filterNegotiable') && document.getElementById(
                    'filterNegotiable').checked) ? '1' : '';
                const is_feat = (document.getElementById('filterFeatured') && document.getElementById(
                    'filterFeatured').checked) ? '1' : '';

                const params = new URLSearchParams();
                if (s) params.set('search', s);
                if (sort) params.set('sort', sort);
                if (selectedCategory !== '' && selectedCategory !== null) params.set('category_id',
                    selectedCategory);
                if (selectedCondition !== '' && selectedCondition !== null) params.set('condition',
                    selectedCondition);
                if (is_neg) params.set('is_negotiable', is_neg);
                if (is_feat) params.set('is_featured', is_feat);
                if (per_page) params.set('per_page', per_page);
                if (page) params.set('page', page);
                return params;
            }

            async function fetchProducts(page = null) {
                try {
                    const params = buildParams(page);
                    const url = routeUrl + (params.toString() ? `?${params.toString()}` : '');
                    container.style.opacity = 0.5;

                    const resp = await fetch(url, {
                        method: 'GET',
                        credentials: 'same-origin',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'text/html'
                        }
                    });
                    if (!resp.ok) throw new Error(`HTTP ${resp.status}`);
                    const html = await resp.text();
                    container.innerHTML = html;

                    // update URL without reload
                    const newUrl = new URL(window.location.href);
                    newUrl.search = params.toString();
                    window.history.replaceState({}, '', newUrl.toString());
                } catch (err) {
                    console.error('Failed to load products:', err);
                    container.innerHTML =
                        `<div class="card"><div class="card-body text-danger">Failed to load products. Try again.</div></div>`;
                } finally {
                    container.style.opacity = 1;
                }
            }

            const debouncedFetch = debounce(() => fetchProducts(), 300);

            // search input
            if (form) {
                form.addEventListener('submit', e => {
                    e.preventDefault();
                    fetchProducts();
                });
                const sInput = form.querySelector('[name=search]');
                if (sInput) sInput.addEventListener('input', debouncedFetch);
            }

            // sort change
            if (sortSel) sortSel.addEventListener('change', () => fetchProducts());

            // categories click
            if (categoriesList) {
                categoriesList.addEventListener('click', (e) => {
                    const item = e.target.closest('[data-cat]');
                    if (!item) return;
                    const newCat = item.getAttribute('data-cat') ?? '';
                    selectedCategory = (newCat === '') ? '' : String(newCat);
                    categoriesList.querySelectorAll('[data-cat]').forEach(el => el.classList.remove(
                        'active'));
                    item.classList.add('active');
                    fetchProducts();
                });
            }

            // condition click
            if (conditionList) {
                conditionList.addEventListener('click', (e) => {
                    const item = e.target.closest('[data-condition]');
                    if (!item) return;
                    selectedCondition = String(item.getAttribute('data-condition'));
                    conditionList.querySelectorAll('[data-condition]').forEach(el => el.classList.remove(
                        'active'));
                    item.classList.add('active');
                    fetchProducts();
                });
            }

            // toggles & per_page
            ['filterNegotiable', 'filterFeatured', 'filterPerPage'].forEach(id => {
                const el = document.getElementById(id);
                if (!el) return;
                el.addEventListener('change', () => fetchProducts());
            });

            // reset filters
            if (resetBtn) {
                resetBtn.addEventListener('click', () => {
                    if (form) form.reset();
                    if (sortSel) sortSel.value = 'latest';
                    selectedCategory = '';
                    selectedCondition = '';
                    if (categoriesList) {
                        categoriesList.querySelectorAll('[data-cat]').forEach(el => el.classList.remove(
                            'active'));
                        const all = categoriesList.querySelector('[data-cat=""]');
                        if (all) all.classList.add('active');
                    }
                    if (conditionList) conditionList.querySelectorAll('[data-condition]').forEach(el => el
                        .classList.remove('active'));
                    document.getElementById('filterNegotiable').checked = false;
                    document.getElementById('filterFeatured').checked = false;
                    document.getElementById('filterPerPage').value = '12';
                    fetchProducts();
                });
            }

            // pagination & links delegation
            container.addEventListener('click', (e) => {
                const a = e.target.closest('a');
                if (!a) return;
                const href = a.getAttribute('href') || '';
                if (!/page=/.test(href)) {
                    // not a pagination link, allow default
                    return;
                }
                e.preventDefault();
                try {
                    const url = new URL(href, window.location.origin);
                    const page = url.searchParams.get('page');
                    fetchProducts(page);
                } catch (err) {
                    fetchProducts();
                }
            });

        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);
            let pond = FilePond.create(document.querySelector('#product-images'), {
                allowMultiple: true,
                acceptedFileTypes: ['image/*'],
                storeAsFile: true,
                credits: false
            });

            const removedInput = document.getElementById('removedImages');
            let removedIds = [];

            function renderExistingImages(images = []) {
                const container = document.getElementById('existing-images');
                container.innerHTML = '';
                removedIds = [];
                removedInput.value = JSON.stringify([]);

                images.forEach(img => {
                    const wrapper = document.createElement('div');
                    wrapper.classList.add('position-relative');
                    wrapper.innerHTML = `
              <img src="${img.url}" width="100" class="rounded">
              <button type="button" class="top-0 btn btn-sm btn-danger position-absolute end-0 btn-remove-existing" data-id="${img.id}">&times;</button>
            `;
                    container.appendChild(wrapper);
                });
            }

            // Remove existing image click
            document.addEventListener('click', e => {
                if (e.target.classList.contains('btn-remove-existing')) {
                    const id = e.target.dataset.id;
                    removedIds.push(id);
                    removedInput.value = JSON.stringify(removedIds);
                    e.target.closest('div').remove();
                }
            });

            // Add Product
            document.getElementById('btnAddProduct').addEventListener('click', () => {
                document.getElementById('productForm').reset();
                document.getElementById('productFormMethod').value = 'POST';
                document.getElementById('productModalTitle').innerText = 'Add Product';
                document.getElementById('productForm').action = "{{ route('products.store') }}";
                renderExistingImages([]);
                pond.removeFiles();
                new bootstrap.Modal(document.getElementById('productModal')).show();
            });

            // Edit Product
            document.addEventListener('click', e => {
                if (e.target.closest('.btn-edit-product')) {
                    const product = JSON.parse(e.target.closest('.btn-edit-product').dataset.product);

                    document.getElementById('productId').value = product.id;
                    document.getElementById('prod-title').value = product.title;
                    document.getElementById('prod-category').value = product.category_id;
                    document.getElementById('prod-price').value = product.price;
                    document.getElementById('prod-quantity').value = product.quantity;
                    document.getElementById('prod-condition').value = product.condition;
                    document.getElementById('prod-description').value = product.description;

                    renderExistingImages(product.images ?? []);
                    pond.removeFiles();

                    document.getElementById('productFormMethod').value = 'PUT';
                    document.getElementById('productModalTitle').innerText = 'Edit Product';
                    document.getElementById('productForm').action = "/products/" + product.id;

                    new bootstrap.Modal(document.getElementById('productModal')).show();
                }
            });
        });
    </script>
@endsection
