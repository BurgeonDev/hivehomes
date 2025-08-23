@extends('frontend.layouts.app')
@section('title', 'Service Providers')

@section('page-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/app-academy.css') }}">
    <style>
        .provider-card {
            border-radius: .5rem;
            transition: box-shadow .3s ease;
        }

        .provider-card:hover {
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.08);
        }

        .provider-card .card-footer {
            padding: .6rem 1rem;
        }

        .kpi-card {
            border-radius: .5rem;
            padding: 1rem;
        }

        .bg-label-success {
            background-color: #e6f9ed !important;
        }

        .filter-card .list-group-item {
            cursor: pointer;
        }

        .rating-stars i {
            font-size: 1rem;
            color: #f1c40f;
            cursor: pointer;
        }

        /* small visual for active filter items */
        .filter-card .list-group-item.active {
            background-color: rgba(13, 110, 253, 0.06);
            border-color: rgba(13, 110, 253, 0.12);
        }

        .rating-clickable {
            cursor: pointer;
        }

        /* keep progress-bar visible when active */
        .rating-clickable.active .progress-bar {
            box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.08);
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

                    {{-- Search --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">Search</h6>
                            <form id="providersFilterForm" class="d-flex" action="javascript:void(0)" method="GET">
                                <input type="search" name="q" class="form-control form-control-sm me-2"
                                    placeholder="Search name or bio…" value="{{ request('q') }}" />
                                <button type="submit" class="btn btn-sm btn-primary">🔍</button>
                            </form>
                        </div>
                    </div>

                    {{-- Type-wise --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3 d-flex justify-content-between">
                                <span>By Type</span>
                                <button id="resetFilters" type="button"
                                    class="btn btn-sm btn-outline-secondary">Reset</button>
                            </h6>
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

                            <div class="gap-2 mb-2 d-flex align-items-center rating-clickable {{ $selectedRating === 5 ? 'active' : '' }}"
                                data-rating="5">
                                <small>5 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['5']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['5']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['5']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center rating-clickable {{ $selectedRating === 4 ? 'active' : '' }}"
                                data-rating="4">
                                <small>4 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['4']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['4']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['4']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center rating-clickable {{ $selectedRating === 3 ? 'active' : '' }}"
                                data-rating="3">
                                <small>3 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['3']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['3']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['3']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center rating-clickable {{ $selectedRating === 2 ? 'active' : '' }}"
                                data-rating="2">
                                <small>2 Star</small>
                                <div class="mx-2 progress w-100 bg-label-primary" style="height: 8px;">
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
                                <div class="mx-2 progress w-100 bg-label-primary" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar"
                                        style="width: {{ $ratingStats['1']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['1']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['1']['count'] ?? 0 }}</small>
                            </div>
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
                                <option value="most_reviewed" {{ request('sort') === 'most_reviewed' ? 'selected' : '' }}>
                                    Most Reviewed</option>
                            </select>
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

            // initial load is already rendered by server — but keep UI reactive:
            // attach 'active' class to matching items based on server request (if needed).
            // (server blade already sets active for types and rating via request()).

            // (Optional) If you want the page to always fetch via AJAX on load (instead of using server-rendered block),
            // uncomment the next line:
            // fetchProviders();

        });
    </script>


@endsection
