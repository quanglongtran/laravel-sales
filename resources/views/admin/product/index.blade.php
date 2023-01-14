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
                                style="display: inline-block; z-index: 1; position: relative;" method="POST">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-danger" data-id="{{ $product->id }}">Delete</button>
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
@endsection

@section('scripts')
    @vite('resources/js/product/index.js')
@endsection
