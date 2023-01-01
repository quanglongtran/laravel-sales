@extends('admin.layouts.app')

@section('title', "Edit User $user->name")

@section('content')
    @include('partials.preview-image')
    <div class="card">
        <h1>Edit user</h1>

        <div>
            <form action="{{ route('user.update', $user->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="preview" style="width: 200px; height: 200px;"
                    default="{{ isset($user->images->url) ? asset("storage/{$user->images->url}") : asset('storage/uploads/users/default-user.webp') }}">
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off"
                        value="{{ old('name') ?? $user->name }}">

                    @error('name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Password</label>
                    <input type="password" class="form-control" name="password">

                    @error('password')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Password confirmation</label>
                    <input type="password" class="form-control" name="password_confirmation">

                    @error('password_confirmation')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Email</label>
                    <input type="email" class="form-control" name="email" autocomplete="off"
                        value="{{ old('email') ?? $user->email }}">

                    @error('email')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Phone</label>
                    <input type="text" class="form-control" name="phone" autocomplete="off"
                        value="{{ old('phone') ?? $user->phone }}">

                    @error('phone')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Address</label>
                    <input type="text" class="form-control" name="address" autocomplete="off"
                        value="{{ old('address') ?? $user->address }}">

                    @error('address')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="d-flex">
                    <div class="form-check p-0">
                        <input class="form-check-input" type="radio" name="gender" id="male-radio"
                            {{ old('gender') == 'male' || $user->gender == 'male' ? 'checked' : '' }} value="male">
                        <label class="custom-control-label" for="male-radio">Male</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="female-radio" value="female"
                            {{ old('gender') == 'female' || $user->gender == 'female' ? 'checked' : '' }}>
                        <label class="custom-control-label" for="female-radio">Female</label>
                    </div>
                </div>

                <div class="input-group input-group-outline my-3">
                    <h3 class="w-100">Roles</h1>

                        @foreach ($roles as $groupName => $role)
                            <div class="col-6">
                                <h4>{{ $groupName }}</h4>

                                <div>
                                    @foreach ($role as $item)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="{{ $item->id }}"
                                                name="role_ids[]" id="role-id-{{ $item->id }}"
                                                {{ $user->roles->contains('id', $item->id) ? 'checked' : '' }}>
                                            <label class="custom-control-label"
                                                for="role-id-{{ $item->id }}">{{ $item->display_name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endforeach
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Update</button>
            </form>
        </div>
    </div>

    <script>
        appendPreviewFrame(document.getElementsByClassName('preview')[0], 'avatar');
    </script>
@endsection
