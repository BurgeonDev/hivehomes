@extends('admin.layouts.app')
@section('title', 'Posts')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">

        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Posts</li>
            </ol>
        </nav>

        <div class="card">
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Posts</h5>
                </div>
                <div class="col-md-auto ms-auto">
                    <div class="flex-wrap mb-0 dt-buttons btn-group">
                        <div class="btn-group">
                            <button class="btn btn-label-primary dropdown-toggle me-4" type="button"
                                data-bs-toggle="dropdown">
                                <span class="gap-2 d-flex align-items-center">
                                    <i class="icon-base ti tabler-upload icon-xs me-sm-1"></i>
                                    <span class="d-none d-sm-inline-block">Export</span>
                                </span>
                            </button>
                            <ul class="dropdown-menu">
                                <li><a class="dropdown-item" href="#" id="export-csv">CSV</a></li>
                                <li><a class="dropdown-item" href="#" id="export-excel">Excel</a></li>
                                <li><a class="dropdown-item" href="#" id="export-pdf">PDF</a></li>
                                <li><a class="dropdown-item" href="#" id="export-print">Print</a></li>
                            </ul>
                        </div>
                        <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasAddPost">
                            <i class="icon-base ti tabler-plus icon-sm"></i>
                            <span class="d-none d-sm-inline-block">Add Post</span>
                        </button>
                    </div>
                </div>
            </div>

            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Society</th>
                            <th>Author</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($posts as $post)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($post->image)
                                        <img src="{{ asset('storage/' . $post->image) }}" class="rounded me-2"
                                            style="width:40px;height:40px;object-fit:cover;">
                                    @endif
                                    {{ $post->title }}
                                </td>
                                <td>{{ $post->category->name ?? '-' }}</td>
                                <td>{{ $post->society->name }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>
                                    <form method="POST" action="{{ route('admin.posts.changeStatus', $post) }}">
                                        @csrf
                                        <select name="status" class="form-select form-select-sm"
                                            onchange="this.form.submit()">
                                            @foreach (['pending', 'approved', 'rejected', 'expired'] as $status)
                                                <option value="{{ $status }}"
                                                    {{ $post->status === $status ? 'selected' : '' }}>
                                                    {{ ucfirst($status) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-info"
                                        onclick="editPost({{ $post }})">Edit</button>
                                    <form method="POST" action="{{ route('admin.posts.destroy', $post) }}"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete?')">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>

            <!-- Offcanvas Add/Edit Post -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasAddPost">
                <div class="offcanvas-header border-bottom">
                    <h5 id="offcanvasTitle" class="offcanvas-title">Add Post</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="flex-grow-0 p-6 mx-0 offcanvas-body h-100">
                    <form method="POST" id="postForm" action="{{ route('admin.posts.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="_method" id="postFormMethod" value="POST">
                        <input type="hidden" name="id" id="post-id">
                        <!-- inside your form, after Title -->
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="post-category" class="form-select">
                                <option value="">— Select Category —</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label">Title</label>
                            <input type="text" name="title" id="post-title" class="form-control" required>
                        </div>

                        <!-- Body -->
                        <div class="mb-3">
                            <label class="form-label">Content</label>
                            <textarea name="body" id="post-body" class="form-control" rows="5" required></textarea>
                        </div>


                        <!-- Current Image Preview -->
                        <div class="mb-3" id="current-image-wrapper" style="display:none;">
                            <label class="form-label">Current Image</label><br>
                            <img src="" id="current-image" class="rounded" style="max-width:100px;">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Image (optional)</label>
                            <input type="file" name="image"
                                class="form-control @error('image') is-invalid @enderror" accept="image/*" />
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            {{-- JS error will insert a <div id="image-size-error"> here --}}
                        </div>


                        <!-- Society -->
                        {{-- only super_admin can choose society --}}
                        @role('super_admin')
                            <div class="mb-4">
                                <label class="form-label">Society</label>
                                <select name="society_id" class="form-select" id="post-society" required>
                                    @foreach ($societies as $society)
                                        <option value="{{ $society->id }}">{{ $society->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            {{-- for everyone else, include a hidden field --}}
                            <input type="hidden" name="society_id" value="{{ auth()->user()->society_id }}">
                        @endrole


                        <button type="submit" class="btn btn-primary me-2" id="postFormSubmit">Submit</button>
                        <button type="reset" class="btn btn-label-danger" data-bs-dismiss="offcanvas">Cancel</button>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
@endsection

@section('page-js')
    <script>
        function editPost(post) {
            $('#postForm').attr('action', `/admin/posts/${post.id}`);
            $('#postFormMethod').val('PUT');
            $('#post-id').val(post.id);
            $('#post-title').val(post.title);
            $('#post-body').val(post.body);
            $('#post-category').val(post.category_id);

            // show current image if exists
            if (post.image) {
                $('#current-image-wrapper').show();
                $('#current-image').attr('src', `/storage/${post.image}`);
            } else {
                $('#current-image-wrapper').hide();
            }

            // society select
            @role('super_admin')
                $('#post-society').val(post.society_id);
            @endrole

            $('#offcanvasTitle').text('Edit Post');
            new bootstrap.Offcanvas($('#offcanvasAddPost')).show();
        }

        $('#offcanvasAddPost').on('hidden.bs.offcanvas', function() {
            // reset form
            $('#postForm').attr('action', '{{ route('admin.posts.store') }}');
            $('#postFormMethod').val('POST');
            $('#post-title,#post-body,#post-id').val('');
            $('#current-image-wrapper').hide();
            $('#offcanvasTitle').text('Add Post');
        });
    </script>
    <script>
        document.getElementById('postForm').addEventListener('submit', function(e) {
            const input = document.querySelector('input[name="image"]');
            if (input.files.length) {
                const file = input.files[0];
                const maxBytes = 2 * 1024 * 1024; // 2 MB in bytes
                if (file.size > maxBytes) {
                    e.preventDefault();
                    // display an error message next to the field
                    let errorEl = document.getElementById('image-size-error');
                    if (!errorEl) {
                        errorEl = document.createElement('div');
                        errorEl.id = 'image-size-error';
                        errorEl.className = 'invalid-feedback d-block';
                        input.parentNode.appendChild(errorEl);
                    }
                    errorEl.textContent = 'Image is too large; maximum size is 2 MB.';
                    input.classList.add('is-invalid');
                }
            }
        });
    </script>
@endsection
