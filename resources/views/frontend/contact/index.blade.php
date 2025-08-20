@extends('frontend.layouts.app')
@section('title', 'Contact Us')

@section('content')

    <section class="overflow-hidden section-py first-section-pt help-center-header position-relative"
        style="min-height: 300px">
        <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Header Background">

        <div class="container bottom-0 pb-4 text-center position-absolute start-50 translate-middle-x">
            <nav aria-label="breadcrumb">
                <ol class="mb-0 breadcrumb justify-content-center fs-4">
                    <li class="breadcrumb-item">
                        <a href="{{ route('home') }}" class="text-decoration-none text-primary">Home</a>
                    </li>
                    <li class="breadcrumb-item active text-dark" aria-current="page">Contact</li>
                </ol>
            </nav>
        </div>
    </section>
    @include('frontend.home.contact')

@endsection
