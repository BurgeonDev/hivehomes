<div class="modal fade" id="serviceProviderModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-simple modal-dialog-centered">
        <div class="modal-content">
            <form id="serviceProviderForm" method="POST" action="{{ route('service-providers.store') }}"
                enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Add Service Provider</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">
                    {{-- Name --}}
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>

                    {{-- Type --}}
                    <div class="mb-3">
                        <label class="form-label">Service Type</label>
                        <select name="type_id" class="form-select">
                            <option value="">-- Select Type --</option>
                            @foreach ($serviceTypes as $type)
                                <option value="{{ $type->id }}">{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Phone / Email --}}
                    <div class="row g-2">
                        <div class="col-md-6">
                            <label class="form-label">Phone</label>
                            <input type="text" name="phone" class="form-control">
                        </div>
                        <div class="col-md-6">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control">
                        </div>
                    </div>

                    {{-- CNIC --}}
                    <div class="mb-3">
                        <label class="form-label">CNIC</label>
                        <input type="text" name="cnic" class="form-control">
                    </div>

                    {{-- Address --}}
                    <div class="mb-3">
                        <label class="form-label">Address</label>
                        <textarea name="address" rows="2" class="form-control"></textarea>
                    </div>

                    {{-- Bio --}}
                    <div class="mb-3">
                        <label class="form-label">Bio / Services Summary</label>
                        <textarea name="bio" rows="3" class="form-control"></textarea>
                    </div>

                    {{-- Profile Image --}}
                    <div class="mb-3">
                        <label class="form-label">Profile Image</label>
                        <input type="file" name="profile_image" class="form-control">
                    </div>

                    @role('super_admin')
                        <div class="mb-3">
                            <label class="form-label">Society</label>
                            <select name="society_id" class="form-select">
                                <option value="">-- Select Society --</option>
                                @foreach ($societies as $society)
                                    <option value="{{ $society->id }}">{{ $society->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    @else
                        <input type="hidden" name="society_id" value="{{ auth()->user()->society_id }}">
                    @endrole
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary rounded-pill"
                        data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
