@extends('frontend.layouts.app')
@section('title', 'Lead Pipeline')
@section('vendor-css')

@endsection
@section('page-css')
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
        @include('frontend.home.customers')
        <!-- Real customers reviews: End -->

        <!-- Our great team: Start -->
        @include('frontend.home.team')
        <!-- Our great team: End -->

        <!-- Pricing plans: Start -->
        @include('frontend.home.pricing')
        <!-- Pricing plans: End -->

        <!-- Fun facts: Start -->
        @include('frontend.home.facts')
        <!-- Fun facts: End -->


        <!-- FAQ: Start -->
        @include('frontend.home.faq')
        <!-- FAQ: End -->


        <!-- CTA: Start -->
        @include('frontend.home.cta')
        <!-- CTA: End -->

        <!-- Contact Us: Start -->
        @include('frontend.home.contact')
        <!-- Contact Us: End -->
    </div>
@endsection
@section('vendor-js')


@endsection
@section('page-js')

@endsection
