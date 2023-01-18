@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('styles')
    <style>
        .ck.ck-reset.ck-editor.ck-rounded-corners {
            width: 100%;
        }

        .ck-blurred.ck.ck-content.ck-editor__editable.ck-rounded-corners.ck-editor__editable_inline:focus {
            min-height: 200px
        }

        .modal-dialog.modal-dialog-centered.modal-sm {
            max-width: 500px;
        }

        .input-group-form {
            display: flex;
            flex-wrap: wrap;
        }

        .input-group-form>* {
            display: flex;
            justify-content: center;
            align-items: center;

            flex-wrap: wrap;
            gap: 0 4px;
        }

        .input-group-form>* :is(:not(:last-child)) {
            width: calc(50% - 28px);
        }
    </style>
@endsection

@section('content')
    @include('partials.preview-image')

    <div class="card">
        <h1>Create product</h1>

        <div>
            <form action="{{ route('admin.product.store') }}" method="POST" enctype="multipart/form-data" id="form-create">
                @csrf

                <div class="preview" style="width: 200px; height: 200px; border-radius: 50%;"></div>

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
                    <label>Price</label>
                    <input type="text" class="form-control" name="price" autocomplete="off"
                        value="{{ old('price') }}">

                    @error('price')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Sale</label>
                    <input type="text" class="form-control" name="sale" autocomplete="off"
                        value="{{ old('sale') }}">

                    @error('sale')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Description</label>
                    <textarea name="description" id="editor" cols="30" rows="10">{{ old('description') }}</textarea>

                    @error('description')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label for="exampleFormControlSelect1" class="ms-0">Example select</label>
                    <select class="form-control" id="exampleFormControlSelect1" name="category_ids[]" multiple>
                        <option value="0">-- Select category --</option>
                        @foreach ($categories as $category)
                            <option {{ collect(old('category_ids'))->contains($category->id) ? 'selected' : '' }}
                                value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>

                <input type="hidden" name="details">

                <button type="button" class="btn btn-submit btn-primary" data-bs-toggle="modal"
                    data-bs-target="#modal-form">Add size</button>
                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>

    <div class="modal fade" id="modal-form" tabindex="-1" role="dialog" aria-labelledby="modal-form" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-sm" role="document">
            <div class="modal-content">
                <div class="modal-body p-0">
                    <div class="card card-plain">
                        <div class="card-header pb-0 text-left">
                            <h5 class="">Add size</h5>
                            {{-- <p class="mb-0">Enter your email and password to sign in</p> --}}
                        </div>
                        <div class="card-body">
                            <div role="form">
                                <div class="d-flex form text-left align-items-center input-group-form">
                                    <div role="group-input-details">
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Size</label>
                                            <input type="text" class="form-control" onfocus="focused(this)"
                                                onfocusout="defocused(this)" data-size="0">
                                        </div>
                                        <div class="input-group input-group-outline my-3">
                                            <label class="form-label">Quantity</label>
                                            <input type="number" class="form-control" onfocus="focused(this)"
                                                onfocusout="defocused(this)" data-quantity="0">
                                        </div>

                                        <div class="btn btn-danger d-flex justify-content-center m-0 disabled"
                                            onclick="deleteInputGroup($(this))" style="flex: 1;">x
                                        </div>
                                    </div>
                                </div>
                                <div class="text-center">
                                    <button type="button"
                                        class="btn btn-round bg-gradient-primary btn-lg w-100 mt-4 mb-0 add-input">Add</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection

@section('scripts')
    <script src="https://cdn.ckeditor.com/ckeditor5/35.4.0/super-build/ckeditor.js"></script>
    @vite('resources/js/product/create.js');
@endsection
