@extends('admin.layouts.app')

@section('title', 'Create Role')

@section('content')
    <div class="card">
        <h1>Create role</h1>

        <div>
            <form action="{{ route('admin.role.store') }}" method="POST">
                @csrf

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off" value="{{ old('name') }}">

                    @error('name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Display name</label>
                    <input type="text" class="form-control" name="display_name" autocomplete="off"
                        {{ old('display_name') }}>

                    @error('display_name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Group</label>
                    <select class="form-control" name="group" id="exampleFormControlSelect1">
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
                                                name="permission_ids[]" id="permission-id-{{ $item->id }}">
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
