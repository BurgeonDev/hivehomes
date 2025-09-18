@extends('admin.layouts.app')
@section('title', 'Trashed ' . ucfirst($type))

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h5 class="mb-4">Trashed {{ ucfirst($type) }}</h5>

        <div class="card">
            <div class="p-3 card-datatable table-responsive">
                <table class="table datatables-basic">
                    <thead>
                        <tr>
                            <th>#</th>
                            @switch($type)
                                @case('societies')
                                    <th>Name</th>
                                    <th>City</th>
                                    <th>Admin</th>
                                @break

                                @case('products')
                                    <th>Name</th>
                                    <th>Category</th>
                                    <th>Price</th>
                                @break

                                @case('posts')
                                    <th>Title</th>
                                    <th>Status</th>
                                    <th>Author</th>
                                @break

                                @case('users')
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                @break
                            @endswitch
                            <th>Deleted At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($items as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>

                                {{-- SOCIETIES --}}
                                @if ($type === 'societies')
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->city->name ?? '-' }}</td>
                                    <td>{{ $item->admin->name ?? '-' }}</td>
                                @endif

                                {{-- PRODUCTS --}}
                                @if ($type === 'products')
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->category->name ?? '-' }}</td>
                                    <td>{{ $item->price }}</td>
                                @endif

                                {{-- POSTS --}}
                                @if ($type === 'posts')
                                    <td>{{ $item->title }}</td>
                                    <td>{{ ucfirst($item->status) }}</td>
                                    <td>{{ $item->user->name ?? '-' }}</td>
                                @endif

                                {{-- USERS --}}
                                @if ($type === 'users')
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->email }}</td>
                                    <td>{{ $item->roles->pluck('name')->join(', ') }}</td>
                                @endif

                                <td>{{ $item->deleted_at->format('d M Y H:i') }}</td>
                                <td>
                                    <form action="{{ route('admin.trash.restore', [$type, $item->id]) }}" method="POST"
                                        class="d-inline">
                                        @csrf @method('PATCH')
                                        <button type="submit" class="btn btn-sm btn-success">Restore</button>
                                    </form>

                                    <form action="{{ route('admin.trash.forceDelete', [$type, $item->id]) }}"
                                        method="POST" class="d-inline delete-form">
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
