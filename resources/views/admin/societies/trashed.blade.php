@extends('admin.layouts.app')
@section('title', 'Trashed Societies')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="mb-4">Trashed Societies</h5>

        <div class="card">
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Name</th>
                            <th>City</th>
                            <th>Admin</th>
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($societies as $society)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $society->name }}</td>
                                <td>{{ $society->city->name ?? '-' }}</td>
                                <td>{{ $society->admin->name ?? '-' }}</td>
                                <td>{{ $society->deleted_at->format('d M Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.societies.restore', $society->id) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                    </form>
                                    <form action="{{ route('admin.societies.forceDelete', $society->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Delete Permanently</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
