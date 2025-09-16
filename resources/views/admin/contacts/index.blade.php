@extends('admin.layouts.app')
@section('title', 'Contact Messages')

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
                            <th>Sender</th>
                            <th>Phone</th>
                            <th>Email</th>
                            <th>Message</th>
                            <th>Date</th>
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

                                {{-- Show truncated but clickable --}}
                                <td>
                                    <a href="javascript:void(0)" onclick="showMessageModal({{ $contact->toJson() }})">
                                        {{ Str::limit($contact->message, 50) }}
                                    </a>
                                </td>

                                <td>{{ $contact->created_at->format('d M Y H:i') }}</td>

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
        </div>
    </div>


    <!-- Modal for Full Message -->
    <div class="modal fade" id="messageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Conversation</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="chatBox" class="gap-3 d-flex flex-column"></div>
                </div>
            </div>
        </div>
    </div>
@endsection


@section('page-js')
    <script>
        function fillReply(contact) {
            const form = document.getElementById('replyForm');
            form.action = `/admin/contacts/${contact.id}/reply`;
            form.querySelector('[name="admin_reply"]').value = contact.admin_reply ?? '';
        }

        document.getElementById('offcanvasReply')?.addEventListener('hidden.bs.offcanvas', function() {
            const form = document.getElementById('replyForm');
            form.action = '';
            form.querySelector('[name="admin_reply"]').value = '';
        });

        // Show modal with chat style messages
        function showMessageModal(contact) {
            const chatBox = document.getElementById('chatBox');
            chatBox.innerHTML = '';

            // User message
            const userMsg = `
                <div class="d-flex justify-content-start">
                    <div class="p-3 border rounded bg-light">
                        <strong>${contact.name}:</strong><br>
                        ${contact.message}
                        <div class="mt-1 text-muted small">${new Date(contact.created_at).toLocaleString()}</div>
                    </div>
                </div>`;
            chatBox.insertAdjacentHTML('beforeend', userMsg);

            // Admin reply (if exists)
            if (contact.admin_reply) {
                const adminMsg = `
                    <div class="d-flex justify-content-end">
                        <div class="p-3 text-white rounded bg-primary">
                            <strong>Admin:</strong><br>
                            ${contact.admin_reply}
                            <div class="mt-1 text-light small">${new Date(contact.updated_at).toLocaleString()}</div>
                        </div>
                    </div>`;
                chatBox.insertAdjacentHTML('beforeend', adminMsg);
            }

            const modal = new bootstrap.Modal(document.getElementById('messageModal'));
            modal.show();
        }
    </script>
@endsection
