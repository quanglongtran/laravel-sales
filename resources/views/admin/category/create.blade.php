@extends('admin.layouts.app')

@section('title', 'Create Category')

@section('content')
    <div class="card">
        <h1>Create category</h1>

        <div>
            <form action="{{ route('admin.category.store') }}" method="POST">
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
                    <label for="exampleFormControlSelect1" class="ms-0">Example select</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="parent_id">
                        <option value="0">-- Select parent category --</option>
                        @foreach ($parentCategories as $parentCategory)
                            <option {{ $parentCategory->id == old('parent_id') ? 'selected' : '' }}
                                value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
