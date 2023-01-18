@extends('admin.layouts.app')

@section('title', 'Users')

@section('content')
    <div class="card">
        <h1>User list</h1>
    </div>

    @can('create-user')
        <div>
            <a href="{{ route('admin.user.create') }}" class="btn btn-primary">Create</a>
        </div>
    @endcan

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
                    <td><img src="{{ $user->image_path }}"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover">
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone }}</td>
                    <td>{{ $user->address }}</td>
                    <td>
                        @can('update-user')
                            <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-warning">Edit</a>
                        @endcan

                        @can('delete-user')
                            <form action="{{ route('admin.user.destroy', $user->id) }}" style="display: inline" method="POST"
                                id="user-form-delete-{{ $user->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-submit-delete-modal"
                                    data-user-id="{{ $user->id }}" data-user-name="{{ $user->name }}"
                                    data-bs-toggle="modal" data-bs-target="#modal-default">Delete</button>
                            </form>
                        @endcan
                    </td>
                </tr>
            @endforeach
        </table>

        {{ $users->links() }}
    </div>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default"
        aria-hidden="true">
        <div class="modal-dialog modal- modal-dialog-centered modal-" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h6 class="modal-title font-weight-normal" id="modal-title-default">Type your modal title</h6>
                    <button type="button" class="btn-close text-dark" data-bs-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger text-white" id="modal-delete-text">Delete</div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn bg-gradient-primary" id="save">Save changes</button>
                    <button type="button" class="btn btn-link  ml-auto" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/admin/user/index.js')
@endsection
