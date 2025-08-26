<!-- Product Modal (Add / Edit) -->
<div class="modal fade" id="productModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content">
            <form id="productForm" action="javascript:void(0)" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalTitle">Add Product</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <div id="productFormAlert" class="alert d-none"></div>

                    <input type="hidden" name="id" id="productId" value="">

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="form-label">Title</label>
                            <input type="text" class="form-control" name="title" id="productTitle" required>
                            <div class="invalid-feedback" id="err-title"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Category</label>
                            <select name="category_id" id="productCategory" class="form-select">
                                <option value="">Select category</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                            <div class="invalid-feedback" id="err-category_id"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Description</label>
                            <textarea name="description" id="productDescription" rows="4" class="form-control"></textarea>
                            <div class="invalid-feedback" id="err-description"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Price</label>
                            <input type="number" step="0.01" class="form-control" name="price" id="productPrice">
                            <div class="invalid-feedback" id="err-price"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Quantity</label>
                            <input type="number" class="form-control" name="quantity" id="productQuantity"
                                value="1" min="1">
                            <div class="invalid-feedback" id="err-quantity"></div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Condition</label>
                            <select name="condition" id="productCondition" class="form-select">
                                <option value="new">New</option>
                                <option value="like_new">Like New</option>
                                <option value="used">Used</option>
                                <option value="refurbished">Refurbished</option>
                                <option value="other">Other</option>
                            </select>
                            <div class="invalid-feedback" id="err-condition"></div>
                        </div>

                        <div class="col-12">
                            <label class="form-label">Images (optional)</label>
                            <input type="file" name="images[]" id="productImages" class="form-control" multiple>
                            <div class="form-text">You can upload multiple images (jpg, png). Max per image depends on
                                server config.</div>
                            <div class="invalid-feedback" id="err-images"></div>
                        </div>

                        <div class="col-12 d-flex gap-3 align-items-center">
                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="productNegotiable"
                                    name="is_negotiable" value="1">
                                <label class="form-check-label" for="productNegotiable">Negotiable</label>
                            </div>

                            <div class="form-check form-switch">
                                <input class="form-check-input" type="checkbox" id="productFeatured"
                                    name="is_featured" value="1">
                                <label class="form-check-label" for="productFeatured">Featured</label>
                            </div>
                        </div>
                    </div> <!-- row -->
                </div> <!-- modal-body -->

                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="productFormSubmit" class="btn btn-primary rounded-pill">
                        <span id="productFormSubmitText">Save</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
