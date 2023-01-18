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
                                <form action="{{ route('admin.role.destroy', $role->id) }}" style="display: inline" method="POST"
                                    id="role-form-delete-{{ $role->id }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-submit-delete-modal" data-bs-toggle="modal"
                                        data-bs-target="#modal-default" data-role-id="{{ $role->id }}"
                                        data-role-name="{{ $role->display_name }}">Delete</button>
                                </form>
                            @endcan
                        </td>
                    </tr>
                @endif
            @endforeach
        </table>

        {{ $roles->links() }}
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
    @vite('resources/js/admin/role/index.js')
@endsection
