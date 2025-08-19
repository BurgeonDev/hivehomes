@extends('frontend.layouts.app')
@section('title', $post->title)

@section('content')

  <section class="overflow-hidden section-py first-section-pt help-center-header position-relative">
    <img class="banner-bg-img z-n1" src="{{ asset('assets/img/pages/header.png') }}" alt="Help center header">
    <h4 class="text-center text-primary">Hello, how can we help?</h4>
    <div class="mx-auto mb-4 input-wrapper input-group input-group-merge position-relative">
      <span class="input-group-text"><i class="icon-base ti tabler-search"></i></span>
      <input type="text" class="form-control" placeholder="Search">
    </div>
    <p class="px-4 mb-0 text-center">Common troubleshooting topics: eCommerce, Blogging, Payments</p>
  </section>


  <section class="section-py bg-body first-section-pt">
    <div class="container">
      <div class="card px-3">
        <div class="row">

          <div class="col-lg-8 card-body border-end p-md-8">
            <h4 class="mb-2">{{ $post->title }}</h4>

            <p class="mb-4">
              By <span class="fw-medium text-heading">{{ $post->user->name }}</span>
              in 
              <span class="badge bg-label-primary text-capitalize">
                {{ $post->category->name ?? 'Uncategorized' }}
              </span>
            </p>

            @if($post->image)
              <img src="{{ asset('storage/'.$post->image) }}"
                   alt="{{ $post->title }}"
                   class="img-fluid rounded mb-4">
            @endif

            <div class="mb-6">
              {!! nl2br(e($post->body)) !!}
            </div>

            <hr class="my-6">

            <h5 class="mb-3">Details</h5>
            <ul class="list-unstyled">
              <li><strong>Society:</strong> {{ $post->society->name }}</li>
              <li><strong>Status:</strong> {{ ucfirst($post->status) }}</li>
              <li><strong>Published:</strong> {{ $post->created_at->format('F j, Y') }}</li>
              <li><strong>Last updated:</strong> {{ $post->updated_at->format('F j, Y') }}</li>
            </ul>
          </div>

          {{-- Right: Author Card (4 cols) --}}
          <div class="col-lg-4 card-body p-md-8">
            <div class="card mb-6">
              <div class="card-body pt-12">
                <div class="user-avatar-section text-center mb-6">
                  <img src="{{ asset('assets/img/avatars/placeholder.png') }}"
                       alt="Avatar"
                       class="img-fluid rounded-circle mb-4"
                       width="120" height="120">
                  <h5>{{ $post->user->name }}</h5>
                  <span class="badge bg-label-secondary">Author</span>
                </div>

                {{-- Stats: use post count --}}
                <div class="d-flex justify-content-around flex-wrap my-6">
                  <div class="text-center">
                    <div class="avatar avatar-initial bg-label-primary rounded mb-2">
                      <i class="icon-base ti tabler-file-text icon-lg"></i>
                    </div>
                    <h5 class="mb-0">{{ $post->user->posts()->count() }}</h5>
                    <small>Posts Written</small>
                  </div>
                </div>

                <h5 class="pb-4 border-bottom mb-4">Contact</h5>
                <ul class="list-unstyled mb-6">
                  <li class="mb-2">
                    <span class="h6">Email:</span>
                    <span>{{ $post->user->email }}</span>
                  </li>
                  <li class="mb-2">
                    <span class="h6">Role:</span>
                    <span class="text-capitalize">{{ $post->user->getRoleNames()->first() ?? 'User' }}</span>
                  </li>
                </ul>

                <div class="d-flex justify-content-center">
                  <a href="mailto:{{ $post->user->email }}"
                     class="btn btn-primary me-2 waves-effect waves-light">
                    Email Author
                  </a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  {{-- Still need help --}}
  <section class="section-py bg-body">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6 text-center">
          <h4>Still need help?</h4>
          <p>
            Our specialists are always happy to help.<br>
            Contact us during standard business hours or email us 24/7 and we'll get back to you.
          </p>
          <div class="d-flex justify-content-center flex-wrap gap-4">
            <a href="{{ route('home') }}" class="btn btn-primary">Visit our community</a>
            <a href="{{ route('contact.store') }}" class="btn btn-primary">Contact us</a>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection
