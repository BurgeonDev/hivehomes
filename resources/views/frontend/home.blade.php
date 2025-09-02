@extends('frontend.layouts.app')
@section('title', 'Home ')
@section('vendor-css')

@endsection
@section('page-css')
    <style>
        .no-image-placeholder {
            height: 180px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            background: linear-gradient(135deg, #adb5bd, #6c757d);
        }
    </style>
@endsection

@section('content')
    <div data-bs-spy="scroll" class="scrollspy-example">
        <!-- Hero: Start -->
        @include('frontend.home.hero')
        <!-- Hero: End -->




        <!-- HiveHomes Features: Start -->
        @include('frontend.home.features')
        <!-- HiveHomes Features: End -->


        <!-- Real customers reviews: Start -->
        @auth
            @if (auth()->user()->is_active === 'active')
                @include('frontend.home.customers')
            @endif
        @endauth
        <!-- Real customers reviews: End -->

        <!-- Our great team: Start -->
        {{-- @include('frontend.home.team') --}}
        <!-- Our great team: End -->

        <!-- Pricing plans: Start -->
        {{-- @include('frontend.home.pricing') --}}
        <!-- Pricing plans: End -->



        <!-- FAQ: Start -->
        {{-- @include('frontend.home.faq') --}}
        <!-- FAQ: End -->


        <!-- CTA: Start -->
        {{-- @include('frontend.home.cta') --}}
        <!-- CTA: End -->

        <!-- Fun facts: Start -->
        @include('frontend.home.facts')
        <!-- Fun facts: End -->


        <!-- Contact Us: Start -->
        {{-- @include('frontend.home.contact') --}}
        <!-- Contact Us: End -->
    </div>
@endsection
@section('vendor-js')


@endsection
@section('page-js')

@endsection
