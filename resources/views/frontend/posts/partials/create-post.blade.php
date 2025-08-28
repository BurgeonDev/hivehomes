<div class="modal fade" id="createPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Header -->
                <div class="pb-0 modal-header border-bottom-0">
                    <h5 class="modal-title fw-bold"> Create New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <!-- Body -->
                <div class="modal-body">
                    <div class="row g-4">

                        {{-- Title --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" for="title">Title</label>
                            <input type="text" id="title" name="title" class="form-control"
                                placeholder="Enter post title" required>
                        </div>

                        {{-- Content --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold">Content</label>

                            <!-- Quill toolbar -->
                            <div id="post-toolbar" class="p-2 mb-2 border rounded bg-light">
                                <span class="ql-formats">
                                    <select class="ql-header">
                                        <option selected></option>
                                        <option value="1"></option>
                                        <option value="2"></option>
                                    </select>
                                    <button class="ql-bold"></button>
                                    <button class="ql-italic"></button>
                                    <button class="ql-underline"></button>
                                    <button class="ql-strike"></button>
                                    <button class="ql-code-block"></button>
                                </span>
                                <span class="ql-formats">
                                    <button class="ql-list" value="ordered"></button>
                                    <button class="ql-list" value="bullet"></button>
                                    <button class="ql-blockquote"></button>
                                    <button class="ql-link"></button>
                                </span>
                            </div>

                            <!-- Quill editor -->
                            <div id="post-editor" class="form-control" style="min-height: 200px; background:#fff;">
                            </div>
                            <input type="hidden" name="body" id="post-body" required>
                        </div>

                        {{-- Category --}}
                        <div class="col-md-6">
                            <label class="form-label fw-semibold" for="category_id">Category</label>
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option value="">-- Select Category --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Society (super_admin only) --}}
                        @if (auth()->user()->hasRole('super_admin'))
                            <div class="col-md-6">
                                <label class="form-label fw-semibold" for="society_id">Society</label>
                                <select class="form-select" id="society_id" name="society_id">
                                    <option value="">-- Select Society --</option>
                                    @foreach ($societies as $society)
                                        <option value="{{ $society->id }}">{{ $society->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        @endif

                        {{-- Image --}}
                        <div class="col-md-12">
                            <label class="form-label fw-semibold" for="image">Post Image (Header)</label>
                            <input class="form-control" type="file" id="image" name="image" accept="image/*">
                        </div>

                    </div>
                </div>

                <!-- Footer -->
                <div class="modal-footer border-top-0">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary">Create Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
