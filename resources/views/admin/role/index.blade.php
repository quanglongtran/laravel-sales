@extends('admin.layouts.app')

@section('title', 'Roles')

@section('content')
    <div class="card">
        <h1>Role list</h1>
    </div>

    @can('create-role')
        <div>
            <a href="{{ route('admin.role.create') }}" class="btn btn-primary">Create</a>
        </div>
    @endcan

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Display Name</th>
                <th>Action</th>
            </tr>

            @foreach ($roles as $role)
                @if ($role->name != 'super-admin')
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>{{ $role->display_name }}</td>
                        <td>
                            @can('update-role')
                                <a href="{{ route('admin.role.edit', $role->id) }}" class="btn btn-warning">Edit</a>
                            @endcan

                            @can('delete-role')
                                <form action="{{ route('admin.role.destroy', $role->id) }}" style="display: inline" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>

        {{ $roles->links() }}
    </div>
@endsection
