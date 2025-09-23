<div class="modal fade" id="editProviderModal-{{ $sp->id }}" tabindex="-1" aria-hidden="true">
    <div class="modal-lg modal-dialog" role="document">
        <div class="modal-content">
            <form action="{{ route('service-providers.update', $sp->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="modal-header">
                    <h5 class="modal-title">Edit Service Provider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    <div class="row g-3">

                        {{-- Name --}}
                        <div class="col-md-6">
                            <label class="form-label">Full Name</label>
                            <input type="text" name="name" class="form-control" value="{{ $sp->name }}"
                                required>
                        </div>

                        {{-- Type --}}
                        <div class="col-md-6">
                            <label class="form-label">Service Type</label>
                            <select name="type_id" class="form-select" required>
                                <option value="">-- Select Type --</option>
                                @foreach ($serviceTypes as $type)
                                    <option value="{{ $type->id }}"
                                        {{ $sp->type_id == $type->id ? 'selected' : '' }}>
                                        {{ $type->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        {{-- Phone --}}
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control" value="{{ $sp->phone }}">
                        </div>

                        {{-- Email --}}
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" value="{{ $sp->email }}">
                        </div>

                        {{-- CNIC --}}
                        <div class="col-md-6">
                            <label class="form-label">CNIC</label>
                            <input type="number" name="cnic" class="form-control" value="{{ $sp->cnic }}">
                        </div>

                        {{-- Address --}}
                        <div class="col-md-6">
                            <label class="form-label">Address</label>
                            <textarea name="address" rows="2" class="form-control">{{ $sp->address }}</textarea>
                        </div>

                        {{-- Bio --}}
                        <div class="col-12">
                            <label class="form-label">Bio / Services Summary</label>
                            <textarea name="bio" rows="3" class="form-control">{{ $sp->bio }}</textarea>
                        </div>

                        {{-- Profile Image --}}
                        <div class="col-12">
                            <label class="form-label">Profile Image</label>
                            <input type="file" name="profile_image" class="form-control" accept="image/*">

                            @if ($sp->profile_image_url)
                                <img src="{{ $sp->profile_image_url }}" class="mt-2 rounded-circle" width="80"
                                    height="80">
                            @else
                                <div class="mt-2 text-white rounded-circle bg-primary d-flex align-items-center justify-content-center"
                                    style="width:80px; height:80px; font-size:22px; font-weight:600;">
                                    {{ strtoupper(substr($sp->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>

                        {{-- Hidden fields for admin-controlled values --}}
                        <input type="hidden" name="is_active" value="{{ $sp->is_active }}">
                        <input type="hidden" name="is_approved" value="{{ $sp->is_approved }}">

                        @role('super_admin')
                            <div class="col-12">
                                <label class="form-label">Society</label>
                                <select name="society_id" class="form-select">
                                    @foreach ($societies as $society)
                                        <option value="{{ $society->id }}"
                                            {{ $sp->society_id == $society->id ? 'selected' : '' }}>
                                            {{ $society->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @else
                            <input type="hidden" name="society_id" value="{{ auth()->user()->society_id }}">
                        @endrole

                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Update Provider</button>
                </div>
            </form>
        </div>
    </div>
</div>
