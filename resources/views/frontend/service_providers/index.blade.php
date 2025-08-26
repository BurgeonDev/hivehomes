@extends('frontend.layouts.app')
@section('title', 'Service Providers')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <style>
        /* --- Card / Filter visuals --- */
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

        /* KPI + provider card small tweaks */
        .provider-card {
            border-radius: .5rem;
            transition: box-shadow .28s ease;
        }

        .provider-card:hover {
            box-shadow: 0 8px 22px rgba(17, 24, 39, 0.06);
        }

        .kpi-card {
            border-radius: .6rem;
            padding: .85rem;
        }

        /* Search input smaller and sleeker */
        #providersFilterForm .form-control {
            height: 36px;
            font-size: .92rem;
            padding: .35rem .6rem;
            border-radius: .45rem;
        }

        #providersFilterForm .btn {
            height: 36px;
            padding: .25rem .7rem;
            font-size: .88rem;
            border-radius: .45rem;
        }

        /* --- Reset toolbar at top --- */
        .filters-top-toolbar {
            display: flex;
            gap: .5rem;
            align-items: center;
            justify-content: space-between;
            padding: .6rem .75rem;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.98), rgba(250, 250, 250, 0.98));
            border-bottom: 1px solid rgba(0, 0, 0, 0.03);
        }

        .filters-top-toolbar .reset-wrap {
            margin-left: auto;
        }

        #resetFilters {
            min-width: 88px;
            padding: .35rem .6rem;
            font-size: .85rem;
        }

        /* --- Ratings compact styles --- */
        .rating-clickable {
            cursor: pointer;
            gap: .5rem;
            padding: .25rem 0;
            align-items: center;
            font-size: .86rem;
        }

        .rating-clickable small {
            width: 52px;
            flex: 0 0 52px;
            font-size: .82rem;
            display: inline-block;
        }

        .rating-clickable .progress {
            height: 6px;
            /* smaller bars */
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

        /* visual for active filter items */
        .filter-card .list-group-item.active {
            background-color: rgba(13, 110, 253, 0.06);
            border-color: rgba(13, 110, 253, 0.12);
        }

        .rating-clickable.active {
            filter: saturate(1.03);
        }

        /* make sidebar visually compact & sticky adjustments */
        .position-sticky {
            top: 95px;
        }

        @media (max-width: 991px) {
            .position-sticky {
                position: static;
                top: auto;
            }
        }

        /* subtle hover */
        .list-group-item:hover {
            background: rgba(0, 0, 0, 0.02);
        }

        /* small icon star (if present) */
        .rating-stars i {
            font-size: .85rem;
            color: #f1c40f;
        }
    </style>
@endsection

@section('content')
    {{-- Banner / Breadcrumb --}}
    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 300px;">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">
        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Service Providers</li>
                </ol>
            </nav>
        </div>
    </section>

    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row g-4">
            {{-- Left: Providers List --}}
            <div class="col-lg-8">
                {{-- KPI --}}
                <div class="mb-4 card">
                    <div class="card-body d-flex align-items-center justify-content-between">
                        <div>
                            <h5 class="mb-1">Service Providers</h5>
                            <small class="text-muted">Browse approved providers</small>
                        </div>
                        <div class="text-center shadow-sm kpi-card bg-label-success">
                            <div class="small text-muted">Total Providers</div>
                            <div class="mb-0 h3">{{ number_format($totalProviders) }}</div>
                        </div>
                    </div>
                </div>

                {{-- Providers List (AJAX) --}}
                <div id="providersContainer">
                    @include('frontend.service_providers.partials.providers-list', [
                        'providers' => $providers,
                    ])
                </div>
            </div>

            {{-- Right: Filters Sidebar --}}
            <div class="col-lg-4">
                <div class="position-sticky" style="top: 95px;">

                    {{-- Top toolbar with Reset (visible at top of searches) --}}
                    <div class="mb-3 card filter-card">
                        <div class="filters-top-toolbar">
                            <div class="small text-muted">Filters</div>
                            <div class="reset-wrap">
                                {{-- Moved reset here so it's visible at top of sidebar --}}
                                <button id="resetFilters" type="button"
                                    class="btn btn-sm btn-outline-secondary">Reset</button>
                            </div>
                        </div>
                    </div>

                    {{-- Search --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Search</h6>
                            <form id="providersFilterForm" class="d-flex" action="javascript:void(0)" method="GET">
                                <input type="search" name="q" class="form-control form-control-sm me-2"
                                    placeholder="Search name or bio…" value="{{ request('q') }}" />
                            </form>
                        </div>
                    </div>
                    {{-- Sort --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Sort By</h6>
                            <select name="sort" class="form-select form-select-sm" id="sortFilter">
                                <option value="newest" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>
                                    Newest</option>
                                <option value="oldest" {{ request('sort') === 'oldest' ? 'selected' : '' }}>Oldest
                                </option>

                            </select>
                        </div>
                    </div>
                    {{-- Type-wise --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">By Type</h6>
                            <ul id="typesList" class="list-group list-group-flush">
                                <li class="list-group-item d-flex justify-content-between {{ request()->filled('type') ? '' : 'active' }}"
                                    data-type="">
                                    <span>All</span>
                                    <span class="badge bg-label-secondary">{{ number_format($totalProviders) }}</span>
                                </li>
                                @foreach ($types as $typeItem)
                                    <li class="list-group-item d-flex justify-content-between {{ request('type') == $typeItem->id ? 'active' : '' }}"
                                        data-type="{{ $typeItem->id }}">
                                        <span>{{ $typeItem->name }}</span>
                                        <span class="badge bg-label-secondary">{{ $typeItem->approved_count }}</span>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>


                    {{-- Rating --}}
                    {{-- Rating Distribution --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body" id="ratingList">
                            <h6 class="mb-3">By Rating</h6>

                            @php
                                $selectedRating = request('rating') ? (int) request('rating') : null;
                            @endphp

                            <div class="gap-2 mb-1 d-flex align-items-center rating-clickable {{ $selectedRating === 5 ? 'active' : '' }}"
                                data-rating="5">
                                <small>5 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['5']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['5']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['5']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-1 d-flex align-items-center rating-clickable {{ $selectedRating === 4 ? 'active' : '' }}"
                                data-rating="4">
                                <small>4 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['4']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['4']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['4']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-1 d-flex align-items-center rating-clickable {{ $selectedRating === 3 ? 'active' : '' }}"
                                data-rating="3">
                                <small>3 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['3']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['3']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['3']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-1 d-flex align-items-center rating-clickable {{ $selectedRating === 2 ? 'active' : '' }}"
                                data-rating="2">
                                <small>2 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['2']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['2']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['2']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 d-flex align-items-center rating-clickable {{ $selectedRating === 1 ? 'active' : '' }}"
                                data-rating="1">
                                <small>1 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['1']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['1']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['1']['count'] ?? 0 }}</small>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('page-js')

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('providersContainer');
            const form = document.getElementById('providersFilterForm');
            const sortSel = document.getElementById('sortFilter');
            const typesList = document.getElementById('typesList');
            const ratingList = document.getElementById('ratingList');
            const resetBtn = document.getElementById('resetFilters');
            const routeUrl = '{{ route('service-providers.index') }}';

            // initial values from server (blade)
            let type = '{{ request('type', '') }}' || '';
            let rating = '{{ request('rating', '') }}' || '';

            // debounce helper
            function debounce(fn, wait) {
                let t;
                return (...args) => {
                    clearTimeout(t);
                    t = setTimeout(() => fn(...args), wait);
                };
            }

            // build query string params
            function buildParams(page = null) {
                const q = (form.querySelector('[name=q]') || {
                    value: ''
                }).value || '';
                const sort = (sortSel && sortSel.value) || 'newest';
                const params = new URLSearchParams();
                if (q) params.set('q', q);
                if (sort) params.set('sort', sort);
                if (type !== '' && type !== null) params.set('type', type);
                if (rating !== '' && rating !== null) params.set('rating', rating);
                if (page) params.set('page', page);
                return params;
            }

            // fetch partial HTML and replace container
            async function fetchProviders(page = null) {
                try {
                    const params = buildParams(page);
                    const url = routeUrl + (params.toString() ? `?${params.toString()}` : '');
                    // show loading state
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

                    // update browser URL without reload
                    const newUrl = new URL(window.location.href);
                    newUrl.search = params.toString();
                    window.history.replaceState({}, '', newUrl.toString());
                } catch (err) {
                    console.error('Failed to load providers:', err);
                    container.innerHTML =
                        `<div class="card"><div class="card-body text-danger">Failed to load providers. Try again.</div></div>`;
                } finally {
                    container.style.opacity = 1;
                }
            }

            // Debounced version for search input
            const debouncedFetch = debounce(() => fetchProviders(), 300);

            // Prevent native form submit (Enter)
            if (form) {
                form.addEventListener('submit', (e) => {
                    e.preventDefault();
                    fetchProviders();
                });

                const qInput = form.querySelector('[name=q]');
                if (qInput) qInput.addEventListener('input', debouncedFetch);
            }

            // sort change
            if (sortSel) {
                sortSel.addEventListener('change', () => fetchProviders());
            }

            // types click (delegated)
            if (typesList) {
                typesList.addEventListener('click', (e) => {
                    const item = e.target.closest('[data-type]');
                    if (!item) return;
                    // grab the data-type attribute (can be empty string)
                    const newType = item.getAttribute('data-type') ?? '';
                    type = newType === '' ? '' : String(newType);
                    // update active classes
                    typesList.querySelectorAll('[data-type]').forEach(el => el.classList.remove('active'));
                    item.classList.add('active');
                    // reset page param by fetching first page
                    fetchProviders();
                });
            }

            // rating click (delegated)
            if (ratingList) {
                ratingList.addEventListener('click', (e) => {
                    const item = e.target.closest('[data-rating]');
                    if (!item) return;
                    rating = String(item.getAttribute('data-rating'));
                    // update active classes
                    ratingList.querySelectorAll('[data-rating]').forEach(el => el.classList.remove(
                        'active'));
                    item.classList.add('active');
                    fetchProviders();
                });
            }

            // reset filters
            if (resetBtn) {
                resetBtn.addEventListener('click', (e) => {
                    if (form) form.reset();
                    if (sortSel) sortSel.value = 'newest';
                    type = '';
                    rating = '';
                    // clear actives
                    if (typesList) typesList.querySelectorAll('[data-type]').forEach(el => el.classList
                        .remove('active'));
                    const allItem = typesList ? typesList.querySelector('[data-type=""]') : null;
                    if (allItem) allItem.classList.add('active');
                    if (ratingList) ratingList.querySelectorAll('[data-rating]').forEach(el => el.classList
                        .remove('active'));
                    fetchProviders();
                });
            }

            // delegate pagination clicks inside providers container
            // when the partial loads it should contain links like ?page=2
            container.addEventListener('click', (e) => {
                const a = e.target.closest('a');
                if (!a) return;
                if (!a.classList.contains('page-link') && !/page=/.test(a.getAttribute('href') || '')) {
                    // not a pagination link (let it behave normally)
                    return;
                }
                e.preventDefault();
                const href = a.getAttribute('href') || '';
                if (!href) return;
                try {
                    const url = new URL(href, window.location.origin);
                    const page = url.searchParams.get('page');
                    fetchProviders(page);
                } catch (err) {
                    // fallback: fetch first page
                    fetchProviders();
                }
            });

        });
    </script>


@endsection
