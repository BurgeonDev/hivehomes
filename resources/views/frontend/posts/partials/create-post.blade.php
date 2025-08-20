<div class="modal fade" id="createPostModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('posts.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Create New Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body row g-4">
                    {{-- Title --}}
                    <div class="col-md-12">
                        <label class="form-label" for="title">Title</label>
                        <input type="text" id="title" name="title" class="form-control" required>
                    </div>

                    {{-- Content --}}
                    <div class="col-md-12">
                        <label class="form-label" for="content">Content</label>
                        <textarea id="body" name="body" rows="4" class="form-control" required></textarea>
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label" for="category_id">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">Select Category</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Society (optional for super_admins) --}}
                    @if (auth()->user()->hasRole('super_admin'))
                        <div class="col-md-6">
                            <label class="form-label" for="society_id">Society</label>
                            <select class="form-select" id="society_id" name="society_id">
                                <option value="">Select Society</option>
                                @foreach ($societies as $society)
                                    <option value="{{ $society->id }}">{{ $society->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Image --}}
                    <div class="col-md-12">
                        <label class="form-label" for="image">Post Image</label>
                        <input class="form-control" type="file" id="image" name="image" accept="image/*">
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Create Post</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>
