@extends('admin.layouts.app')

@section('title', 'Products')

@section('styles')
    <style>
        .redirect {
            position: absolute;
            width: 100%;
            height: 100%;
            left: 50%;
            top: 50%;
            translate: -50% -50%;
            z-index: 0;
            cursor: pointer;
        }

        .z-1 {
            z-index: 1;
        }
    </style>
@endsection

@section('content')

    @php
        $module = preg_replace('/=/', '', base64_encode(__FILE__)) . \Illuminate\Support\Str::random(5);
    @endphp

    <div class="card">
        <h1>Product list</h1>
    </div>

    @can('create-product')
        <div>
            <a href="{{ route('admin.product.create') }}" class="btn btn-primary">Create</a>
        </div>
    @endcan

    <div>
        <table class="table table-hover">
            <tr>
                <th>#</th>
                <th>Image</th>
                <th>Name</th>
                <th>Price</th>
                <th>Sale</th>
                <th>Action</th>
            </tr>

            @foreach ($products as $product)
                <tr style="position: relative;">
                    <td>{{ $product->id }}</td>
                    <td><img src="{{ $product->image_path }}"
                            onerror="this.src='{{ asset('storage/uploads/products/default.jpg') }}'"
                            style="width: 80px; height: 80px; border-radius: 50%; object-fit: cover">
                    </td>
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->price }}</td>
                    <td>{{ $product->sale }}</td>
                    <td>
                        @can('update-product')
                            <a href="{{ route('admin.product.edit', $product->id) }}" class="btn btn-warning z-1">Edit</a>
                        @endcan

                        @can('delete-product')
                            <form action="{{ route('admin.product.destroy', $product->id) }}"
                                style="display: inline-block; z-index: 1; position: relative;" method="POST"
                                id="product-form-delete-{{ $product->id }}">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn btn-danger btn-submit-delete-modal"
                                    data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}"
                                    data-bs-toggle="modal" data-bs-target="#modal-default">Delete</button>
                            </form>
                        @endcan
                    </td>
                    @can('show-product')
                        <td class="redirect" href="{{ route('admin.product.show', $product->id) }}"></td>
                    @endcan
                </tr>
            @endforeach
        </table>

        {{ $products->links() }}
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
    @vite('resources/js/admin/product/index.js')
@endsection
