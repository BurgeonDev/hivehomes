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
                            <form id="providersFilterForm" class="d-flex">
                                <input type="search" name="q" class="form-control form-control-sm me-2"
                                    placeholder="Search name or bio…" />
                                <button class="btn btn-sm btn-primary">🔍</button>
                            </form>
                        </div>
                    </div>

                    {{-- Type-wise --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">By Type</h6>
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item" data-type="">All</li>
                                <li class="list-group-item" data-type="Plumber">Plumber</li>
                                <li class="list-group-item" data-type="Electrician">Electrician</li>
                                <li class="list-group-item" data-type="Carpenter">Carpenter</li>
                                <!-- add more types as needed -->
                            </ul>
                        </div>
                    </div>

                    {{-- Rating --}}
                    {{-- Rating Distribution --}}
                    <div class="mb-4 card filter-card">
                        <div class="card-body">
                            <h6 class="mb-3">By Rating</h6>

                            <div class="gap-2 mb-2 d-flex align-items-center">
                                <small>5 Star</small>
                                <div class="progress w-100 bg-label-primary" style="height: 8px; cursor:pointer"
                                    data-rating="5">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $ratingStats['5']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['5']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['5']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center">
                                <small>4 Star</small>
                                <div class="progress w-100 bg-label-primary" style="height: 8px; cursor:pointer"
                                    data-rating="4">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $ratingStats['4']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['4']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['4']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center">
                                <small>3 Star</small>
                                <div class="progress w-100 bg-label-primary" style="height: 8px; cursor:pointer"
                                    data-rating="3">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $ratingStats['3']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['3']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['3']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 mb-2 d-flex align-items-center">
                                <small>2 Star</small>
                                <div class="progress w-100 bg-label-primary" style="height: 8px; cursor:pointer"
                                    data-rating="2">
                                    <div class="progress-bar bg-primary" role="progressbar"
                                        style="width: {{ $ratingStats['2']['percent'] ?? 0 }}%"
                                        aria-valuenow="{{ $ratingStats['2']['count'] ?? 0 }}" aria-valuemin="0"
                                        aria-valuemax="100"></div>
                                </div>
                                <small class="w-px-20 text-end">{{ $ratingStats['2']['count'] ?? 0 }}</small>
                            </div>

                            <div class="gap-2 d-flex align-items-center">
                                <small>1 Star</small>
                                <div class="progress w-100 bg-label-primary" style="height: 8px; cursor:pointer"
                                    data-rating="1">
                                    <div class="progress-bar bg-primary" role="progressbar"
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
                                <option value="newest">Newest</option>
                                <option value="oldest">Oldest</option>
                                <option value="most_reviewed">Most Reviewed</option>
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
            const form = $('#providersFilterForm');
            const container = $('#providersContainer');
            const sortSel = $('#sortFilter');
            let currentType = '';
            let currentRating = '';

            // on form submit (search)
            form.on('submit', e => {
                e.preventDefault();
                fetchProviders(form.serialize());
            });

            // type list click
            $('.filter-card [data-type]').on('click', function() {
                currentType = $(this).data('type');
                fetchProviders(
                    `type=${currentType}&q=${form.find('[name=q]').val()}&sort=${sortSel.val()}&rating=${currentRating}`
                );
            });

            // rating click
            $('.rating-stars [data-rating]').on('click', function() {
                currentRating = $(this).data('rating');
                fetchProviders(
                    `rating=${currentRating}&q=${form.find('[name=q]').val()}&sort=${sortSel.val()}&type=${currentType}`
                );
            });

            // sort change
            sortSel.on('change', () => {
                fetchProviders(
                    `sort=${sortSel.val()}&q=${form.find('[name=q]').val()}&type=${currentType}&rating=${currentRating}`
                );
            });

            // pagination links
            container.on('click', '.pagination a', function(e) {
                e.preventDefault();
                const url = new URL($(this).attr('href'), window.location.origin);
                fetchProviders(url.searchParams.toString());
            });

            function fetchProviders(params) {
                $.ajax({
                    url: '{{ route('service-providers.index') }}',
                    data: params,
                    beforeSend() {
                        container.fadeTo(200, .5);
                    },
                    success(html) {
                        container.html(html);
                    },
                    complete() {
                        container.fadeTo(200, 1);
                    }
                });
            }
            // rating filter by clicking progress bar
            $('.filter-card [data-rating]').on('click', function() {
                currentRating = $(this).data('rating');
                fetchProviders(
                    `rating=${currentRating}&q=${form.find('[name=q]').val()}&sort=${sortSel.val()}&type=${currentType}`
                );
            });
        });
    </script>
@endsection
