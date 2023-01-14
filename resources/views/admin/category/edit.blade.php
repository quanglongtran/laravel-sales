@extends('admin.layouts.app')

@section('title', "Edit User $category->name")

@section('content')
    <div class="card">
        <h1>Edit category</h1>

        <div>
            <form action="{{ route('admin.category.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" class="form-control" name="name" autocomplete="off"
                        value="{{ old('name') ?? $category->name }}">

                    @error('name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                @if ($category->children->count() <= 0)
                    <div class="input-group input-group-static mb-4">
                        <label for="exampleFormControlSelect1" class="ms-0">Example select</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="parent_id">
                            <option value="0">-- Select parent category --</option>
                            @foreach ($parentCategories as $parentCategory)
                                <option
                                    {{ $parentCategory->id == old('parent_id') || $parentCategory->id == optional($category->parent)->id ? 'selected' : '' }}
                                    value="{{ $parentCategory->id }}">{{ $parentCategory->name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <button type="submit" class="btn btn-submit btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
