@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <div class="card">
        <h1>User list</h1>
    </div>

    <div>
        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Create</a>
    </div>

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Avatar</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Action</th>
            </tr>

            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td><img src="{{ isset($user->images->url) ? "storage/{$user->images->url}" : asset('storage/uploads/users/default-user.webp') }}"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('admin.user.destroy', $user->id) }}" style="display: inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger" data-id="{{ $user->id }}">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>
@endsection
