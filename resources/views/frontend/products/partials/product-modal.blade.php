<!-- Product Modal -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="productForm" method="POST" action="{{ route('products.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="productFormMethod" value="POST">
                <input type="hidden" name="id" id="productId">
                <input type="hidden" id="prod-society" name="society_id">

                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" id="prod-title" class="form-control" required>
                    </div>

                    {{-- Category --}}
                    <div class="mb-3">
                        <label class="form-label">Category</label>
                        <select name="category_id" id="prod-category" class="form-select">
                            <option value="">-- Select --</option>
                            @foreach ($categories as $cat)
                                <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Price / Qty --}}
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" name="price" id="prod-price" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Quantity</label>
                            <input type="number" name="quantity" id="prod-quantity" class="form-control" value="1"
                                min="1">
                        </div>
                    </div>

                    {{-- Condition --}}
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

                    {{-- Description --}}
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea name="description" id="prod-description" rows="3" class="form-control"></textarea>
                    </div>

                    {{-- Existing Images --}}
                    <div class="mb-3">
                        <label class="form-label">Existing Images</label>
                        <div id="existing-images" class="flex-wrap gap-2 d-flex"></div>
                        <input type="hidden" name="removed_images" id="removedImages" value="[]">
                    </div>

                    {{-- FilePond --}}
                    <div class="mb-3">
                        <label class="form-label">Upload Images</label>
                        <input type="file" id="product-images" name="images[]" multiple>
                    </div>
                    @role('super_admin')
                        <div class="mb-3">
                            <label class="form-label">Society</label>
                            <select name="society_id" id="prod-society" class="form-select">
                                <option value="">-- Select Society --</option>
                                @foreach ($societies as $society)
                                    <option value="{{ $society->id }}">{{ $society->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endrole

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill" id="productFormSubmit">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
