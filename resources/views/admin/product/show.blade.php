@extends('admin.layouts.app')

@section('title', 'Create Product')

@section('styles')
    <style>
        .card {
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            gap: 3rem 0;
            justify-content: space-evenly;
            align-items: start;

        }

        .details {
            display: flex;
            justify-content: space-between;
            width: 100%;
        }

        .details>* {
            width: 100%;
            display: block;
            box-sizing: border-box;
            text-align: center;
            background-color: #f8f8f8;
            border: 1px solid #ccc;
        }
    </style>
@endsection

@section('content')


    <div class="col-12">
        <div class="card px-3">
            <h1>Show product</h1>
            <div class="w-100"></div>

            <img src="{{ "/storage/{$product->images->url}" ?? asset('storage/uploads/default/default.jpg') }}"
                style="width: 200px; height: 200px; border-radius: 50%; object-fit: cover;">
            <div>

                <div class="input-group input-group-static mb-4">
                    <b>Name</b>: {{ $product->name }}
                </div>

                <div class="input-group input-group-static mb-4">
                    <b>Price</b>: {{ $product->price }}đ
                </div>

                <div class="input-group input-group-static mb-4">
                    <b>Sale</b>: {{ $product->sale }}
                </div>

                <div class="input-group input-group-static mb-4">
                    <b>Details</b>:
                    @foreach ($product->details as $detail)
                        <div class="details">
                            <div>Size: {{ $detail->size }}</div>
                            <div>Quantity: {{ $detail->quantity }}</div>
                        </div>
                    @endforeach
                </div>

                <div class="input-group input-group-static mb-4">
                    <b>Categories</b>:
                    @foreach ($product->categories as $category)
                        {{ $category->name . ($loop->index < $product->categories->count() - 1 ? ',' : '') }}
                    @endforeach
                </div>

            </div>

            <div class="description w-100">
                <b>Description</b>: <?= $product->description ?>
            </div>
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
