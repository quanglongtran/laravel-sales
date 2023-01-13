@extends('admin.layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="card">
        <h1>Role list</h1>
    </div>

    <div>
        <a href="{{ route('admin.role.create') }}" class="btn btn-primary">Create</a>
    </div>

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Action</th>
            </tr>

            @foreach ($roles as $role)
                <tr>
                    <td>{{ $role->id }}</td>
                    <td>{{ $role->name }}</td>
                    <td>{{ $role->display_name }}</td>
                    <td>
                        <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-warning">Edit</a>

                        <form action="{{ route('admin.role.destroy', $role->id) }}" style="display: inline" method="POST">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $roles->links() }}
    </div>
@endsection
