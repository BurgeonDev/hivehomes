<div class="modal fade" id="editPostModal-{{ $post->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Post</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-4">
                    {{-- Title --}}
                    <div class="col-md-12">
                        <label class="form-label">Title</label>
                        <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
                    </div>

                    {{-- Body (Quill) --}}
                    <div class="col-md-12">
                        <label class="form-label">Content</label>

                        <div id="edit-toolbar-{{ $post->id }}" class="mb-2">
                            <button class="ql-bold"></button>
                            <button class="ql-italic"></button>
                            <button class="ql-underline"></button>
                            <button class="ql-list" value="ordered"></button>
                            <button class="ql-list" value="bullet"></button>
                        </div>

                        <div id="edit-editor-{{ $post->id }}" style="min-height:200px; background:#fff;">
                        </div>

                        <input type="hidden" name="body" id="edit-body-{{ $post->id }}">
                    </div>

                    {{-- Category --}}
                    <div class="col-md-6">
                        <label class="form-label">Category</label>
                        <select name="category_id" class="form-select" required>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ $post->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    {{-- Society (only for super admins) --}}
                    @if (auth()->user()->hasRole('super_admin'))
                        <div class="col-md-6">
                            <label class="form-label">Society</label>
                            <select name="society_id" class="form-select" required>
                                <option value="">-- Select Society --</option>
                                @foreach ($societies as $society)
                                    <option value="{{ $society->id }}"
                                        {{ isset($post) && $post->society_id == $society->id ? 'selected' : '' }}>
                                        {{ $society->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endif

                    {{-- Image --}}
                    <div class="col-md-12">
                        <label class="form-label">Post Image</label>
                        <input class="form-control" type="file" name="image" accept="image/*">
                        @if ($post->image)
                            <img src="{{ asset('storage/' . $post->image) }}" class="mt-2" width="100">
                        @endif
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
    document.addEventListener("DOMContentLoaded", () => {
        if (!window.editQuill{{ $post->id }}) {
            const quill = new Quill("#edit-editor-{{ $post->id }}", {
                modules: {
                    toolbar: "#edit-toolbar-{{ $post->id }}"
                },
                theme: "snow"
            });
            quill.clipboard.dangerouslyPasteHTML(@json($post->body));

            const hidden = document.getElementById("edit-body-{{ $post->id }}");
            quill.on("text-change", () => {
                hidden.value = quill.root.innerHTML;
            });
            hidden.value = quill.root.innerHTML;
            window.editQuill{{ $post->id }} = quill;
        }
    });
</script>
