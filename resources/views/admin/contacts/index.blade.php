@extends('admin.layouts.app')
@section('title', 'Contact Messages')

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
                <li class="breadcrumb-item active">Contact Messages</li>
            </ol>
        </nav>

        <div class="card">
            <!-- Card Header -->
            <div class="px-3 mx-0 row card-header flex-column flex-md-row border-bottom">
                <div class="col-md-auto me-auto">
                    <h5 class="mb-0 card-title">Contact Messages</h5>
                </div>
            </div>

            <!-- DataTable -->
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Status</th>
                            <th>Reply</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($contacts as $contact)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $contact->name }}</td>
                                <td>{{ $contact->phone }}</td>
                                <td>{{ $contact->email }}</td>
                                <td>{{ Str::limit($contact->message, 50) }}</td>
                                <td>
                                    @if ($contact->is_seen)
                                        <span class="badge bg-label-success">Replied</span>
                                    @else
                                        <span class="badge bg-label-warning">Pending</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="offcanvas"
                                        data-bs-target="#offcanvasReply" onclick="fillReply({{ $contact }})">
                                        Reply
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Offcanvas for Reply -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasReply">
                <div class="offcanvas-header border-bottom">
                    <h5 class="offcanvas-title">Reply to Message</h5>
                    <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"></button>
                </div>
                <div class="p-4 offcanvas-body">
                    <form method="POST" id="replyForm">
                        @csrf
                        <textarea name="admin_reply" class="mb-3 form-control" rows="5" placeholder="Write your reply..."></textarea>
                        <button type="submit" class="btn btn-primary">Send Reply</button>
                        <button type="button" class="btn btn-label-danger ms-2" data-bs-dismiss="offcanvas">Cancel</button>
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
        function fillReply(contact) {
            const form = document.getElementById('replyForm');
            form.action = `/admin/contacts/${contact.id}/reply`;
            form.querySelector('[name="admin_reply"]').value = contact.admin_reply ?? '';
        }

        document.getElementById('offcanvasReply').addEventListener('hidden.bs.offcanvas', function() {
            const form = document.getElementById('replyForm');
            form.action = '';
            form.querySelector('[name="admin_reply"]').value = '';
        });
    </script>
@endsection
