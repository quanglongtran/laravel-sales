@extends('admin.layouts.app')

@section('title', "Edit Role $role->name")

@section('content')
    <div class="card">
        <h1>Edit role</h1>

        <div>
            <form action="{{ route('admin.role.update', $role->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off"
                        value="{{ old('name') ?? $role->name }}">

                    @error('name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Display name</label>
                    <input type="text" class="form-control" name="display_name" autocomplete="off"
                        value="{{ old('display_name') ?? $role->display_name }}">

                    @error('display_name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Group</label>
                    <select class="form-control" name="group" id="exampleFormControlSelect1" value="{{ $role->group }}">
                        <option value="system">System</option>
                        <option value="user">User</option>
                    </select>

                    @error('group')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-outline my-3">
                    <h3 class="w-100">Permission</h1>

                        @foreach ($permissions as $groupName => $permission)
                            <div class="col-6">
                                <h4>{{ $groupName }}</h4>

                                <div>
                                    @foreach ($permission as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                                name="permission_ids[]" id="permission-id-{{ $item->id }}"
                                                {{ $role->permissions->contains('name', $item->name) ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="permission-id-{{ $item->id }}">{{ $item->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
