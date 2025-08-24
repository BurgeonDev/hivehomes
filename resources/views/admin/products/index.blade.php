@extends('admin.layouts.app')
@section('title', 'Products')

@section('vendor-css')
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }}" />
    {{-- FilePond CSS --}}
    <link href="https://unpkg.com/filepond/dist/filepond.css" rel="stylesheet">
    <link href="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.css" rel="stylesheet">

@endsection

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        {{-- Breadcrumb --}}
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active">Products</li>
            </ol>
        </nav>

        {{-- Card & Table --}}
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0">Products</h5>
                <button class="btn btn-primary" data-bs-toggle="offcanvas" data-bs-target="#offcanvasProduct"
                    id="btnAddProduct">
                    <i class="ti ti-plus me-1"></i> Add Product
                </button>
            </div>
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic table-striped">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Image</th>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Price</th>
                            <th>Status</th>
                            <th>Seller</th>
                            <th class="text-end">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    @if ($p->primaryImage)
                                        <img src="{{ $p->primaryImage->url ?? asset('storage/' . $p->primaryImage->path) }}"
                                            width="60" class="rounded">
                                    @else
                                        <span class="text-muted">No image</span>
                                    @endif
                                </td>
                                <td>{{ $p->title }}</td>
                                <td>{{ $p->category->name ?? '-' }}</td>
                                <td>${{ number_format($p->price, 2) }}</td>
                                <td>
                                    <span class="badge bg-label-{{ $p->status == 'approved' ? 'success' : 'warning' }}">
                                        {{ ucfirst($p->status) }}
                                    </span>
                                </td>
                                <td>{{ $p->seller->name }}</td>
                                <td class="text-end">
                                    <button class="btn btn-sm btn-info btn-edit-product"
                                        data-product='@json($p)'>
                                        Edit
                                    </button>
                                    <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Delete this product?')">
                                            Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Offcanvas Add/Edit --}}
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasProduct">
        <div class="offcanvas-header">
            <h5 id="offcanvasProductTitle" class="offcanvas-title">Add Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <form id="productForm" action="{{ route('admin.products.store') }}" method="POST"
                enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="productFormMethod" value="POST">

                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" id="prod-title" class="form-control" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" id="prod-category" class="form-select">
                        <option value="">-- Select --</option>
                        @foreach ($categories as $cat)
                            <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Price</label>
                    <input type="number" name="price" id="prod-price" step="0.01" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantity</label>
                    <input type="number" name="quantity" id="prod-quantity" class="form-control" min="1"
                        value="1">
                </div>

                <div class="mb-3">
                    <label class="form-label">Condition</label>
                    <select name="condition" id="prod-condition" class="form-select">
                        <option value="new">New</option>
                        <option value="like_new">Like New</option>
                        <option value="used">Used</option>
                        <option value="refurbished">Refurbished</option>
                        <option value="other">Other</option>
                    </select>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_negotiable" id="prod-negotiable"
                        value="1">
                    <label class="form-check-label" for="prod-negotiable">Negotiable?</label>
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" type="checkbox" name="is_featured" id="prod-featured"
                        value="1">
                    <label class="form-check-label" for="prod-featured">Featured?</label>
                </div>

                <div class="mb-3">
                    <label class="form-label">Featured Until</label>
                    <input type="datetime-local" name="featured_until" id="prod-featured-until" class="form-control">
                </div>

                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" id="prod-description" rows="3" class="form-control"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Existing Images</label>
                    <div id="existing-images" class="flex-wrap gap-2 d-flex"></div>
                    <!-- removed images will be stored as JSON array string -->
                    <input type="hidden" name="removed_images" id="removedImages" value="[]">
                </div>

                <div class="mb-3">
                    <label class="form-label">Images</label>
                    <input type="file" name="images[]" id="product-images" multiple />
                </div>

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
                <div class="mb-3">
                    <label class="form-label">Status</label>
                    <select name="status" id="prod-status" class="form-select">
                        <option value="pending">Pending</option>
                        <option value="approved">Approved</option>
                        <option value="rejected">Rejected</option>
                    </select>
                </div>

                <div class="gap-2 d-flex">
                    <button type="submit" id="productFormSubmit" class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-secondary" data-bs-dismiss="offcanvas">Cancel</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@section('vendor-js')
    <script src="{{ asset('assets/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.js') }}"></script>
    {{-- FilePond JS --}}
    <script src="https://unpkg.com/filepond/dist/filepond.js"></script>
    <script src="https://unpkg.com/filepond-plugin-image-preview/dist/filepond-plugin-image-preview.js"></script>
    <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>

@endsection

@section('page-js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const storeRoute = @json(route('admin.products.store'));

            FilePond.registerPlugin(FilePondPluginImagePreview, FilePondPluginFileValidateType);

            const pondElement = document.querySelector('#product-images');
            let pond = null;
            if (pondElement) {
                pond = FilePond.create(pondElement, {
                    allowMultiple: true,
                    acceptedFileTypes: ['image/*'],
                    credits: false,
                    storeAsFile: true
                });
            }

            // helper to render existing images thumbnails
            const existingImagesContainer = $('#existing-images');
            const removedInput = $('#removedImages');
            let removedIds = []; // track image ids to be removed

            function renderExistingImages(images = []) {
                existingImagesContainer.empty();
                removedIds = [];
                removedInput.val(JSON.stringify(removedIds));

                if (!images.length) {
                    existingImagesContainer.append('<div class="text-muted">No existing images</div>');
                    return;
                }

                images.forEach(img => {
                    // img should include: id and url (ensure controller/model provides url)
                    const id = img.id ?? null;
                    const url = img.url ?? img.path ?? '';

                    if (!id || !url) return;

                    const wrapper = $(`
                <div class="existing-image-item position-relative" style="width:120px">
                    <img src="${url}" class="rounded img-fluid" style="width:120px; height:80px; object-fit:cover;">
                    <button type="button" class="btn btn-sm btn-danger btn-remove-existing position-absolute" data-image-id="${id}" style="top:6px; right:6px;">&times;</button>
                </div>
            `);
                    existingImagesContainer.append(wrapper);
                });
            }

            // handle click to remove existing image (just from UI, mark removed)
            $(document).on('click', '.btn-remove-existing', function() {
                const btn = $(this);
                const id = btn.data('image-id');

                // mark visually removed
                btn.closest('.existing-image-item').fadeOut(150);

                // track id
                if (id && !removedIds.includes(id)) {
                    removedIds.push(id);
                    removedInput.val(JSON.stringify(removedIds));
                }
            });

            // Add Product click resets form & thumbnails
            $('#btnAddProduct').on('click', function() {
                $('#productForm').trigger('reset').attr('action', storeRoute);
                $('#productFormMethod').val('POST');
                $('#offcanvasProductTitle').text('Add Product');
                $('#productFormSubmit').text('Submit');

                if (pond) pond.removeFiles();
                renderExistingImages([]); // clear thumbnails
            });

            // Edit handler
            $(document).on('click', '.btn-edit-product', function() {
                const product = $(this).data('product');
                const productId = (product && product.id) ? product.id : $(this).data('product-id');
                if (!productId) {
                    console.error('No product data for edit');
                    return;
                }
                const p = product || {
                    id: productId,
                    images: []
                };

                // form action for update
                $('#productForm').attr('action', '/admin/products/' + p.id);
                $('#productFormMethod').val('PUT');

                // fill fields
                $('#prod-title').val(p.title ?? '');
                $('#prod-category').val(p.category_id ?? '');
                $('#prod-price').val(p.price ?? '');
                $('#prod-quantity').val(p.quantity ?? 1);
                $('#prod-condition').val(p.condition ?? 'new');
                $('#prod-negotiable').prop('checked', !!p.is_negotiable);
                $('#prod-featured').prop('checked', !!p.is_featured);
                $('#prod-featured-until').val(p.featured_until ? p.featured_until.slice(0, 16) : '');
                $('#prod-description').val(p.description ?? '');
                $('#prod-status').val(p.status ?? 'pending');
                if ($('#post-society').length) $('#post-society').val(p.society_id ?? '');

                // show existing images (THUMBNAILS + remove buttons)
                renderExistingImages(p.images ?? []);

                // Reset FilePond (we'll use it only for new uploads)
                if (pond) pond.removeFiles();

                // UI text
                $('#offcanvasProductTitle').text('Edit Product');
                $('#productFormSubmit').text('Save');

                // show offcanvas
                const offcanvasElement = document.getElementById('offcanvasProduct');
                const offcanvas = new bootstrap.Offcanvas(offcanvasElement);
                offcanvas.show();
            });

            // on offcanvas close — reset
            $('#offcanvasProduct').on('hidden.bs.offcanvas', function() {
                $('#productForm').attr('action', storeRoute).trigger('reset');
                $('#productFormMethod').val('POST');
                $('#offcanvasProductTitle').text('Add Product');
                $('#productFormSubmit').text('Submit');
                if (pond) pond.removeFiles();
                renderExistingImages([]);
            });

            // Note: form is allowed to submit normally; on server side handle removed_images and new uploads
        });
    </script>



@endsection
