@extends('client.layouts.app')

@section('title', 'Cart page')

@section('styles')
    <style>
        td,
        th {
            text-align: left;
            vertical-align: middle !important;

        }

        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection

@section('content')
    <div class="container-fluid mb-5">
        <div class="row px-xl-5">
            <div class="col-lg-9 col-md-12">
                <table class="table table-hover">
                    <tr class="bg-secondary">
                        <th>Name</th>
                        <th>Price</th>
                        <th>Size</th>
                        <th>Sale</th>
                        <th>Quantity</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>

                    @foreach ($cartProducts as $cartProduct)
                        <tr class="cart-row" data-cart-quantity="{{ $cartProduct->product_quantity }}">
                            <td>{{ $cartProduct->product->name }}</td>
                            <td class="price">{{ $cartProduct->product_price }}</td>
                            <td>{{ $cartProduct->product_size }}</td>
                            <td>{{ $cartProduct->product->sale }}</td>
                            <td>
                                <div class="d-flex align-items-center mb-4 pt-2">
                                    <div class="input-group quantity quantity-group-btn" style="width: auto;"
                                        data-quantity="{{ $cartProduct->product_quantity }}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-minus">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="number" class="show-quantity form-control bg-secondary text-center"
                                            value="{{ $cartProduct->product_quantity }}" style="width: 40px;" />

                                        <div class="input-group-btn">
                                            <button class="btn btn-primary btn-plus">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-danger over-quantity"></span>
                            </td>
                            <td class="total-price" data-product-price="{{ $cartProduct->product_price }}"></td>
                            <td>
                                <form action="{{ route('cart.update-quantity', $cartProduct->id) }}" style="display: inline"
                                    method="POST" class="cart-product-form-save">
                                    @csrf
                                    <input type="hidden" name="product_quantity">

                                    <button type="submit"
                                        onclick="$(this).parent().find('input[name=product_quantity]').val(0)"
                                        class="btn-submit-action btn bg-danger btn-submit-delete text-white rounded">
                                        ×
                                    </button>

                                    <button type="submit"
                                        class="btn-submit-action btn bg-info btn-submit-save text-white rounded">
                                        &#10003;
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </table>
            </div>

            <div class="col-lg-3">
                <form class="mb-5" method="POST" action="{{ route('cart.apply-coupon') }}">
                    @csrf
                    <div class="input-group">
                        <input type="text" class="form-control p-4"
                            value="{{ Session::get('coupon_code') ?? 'Coupon Estel Torphy' }}" name="coupon_code"
                            placeholder="Coupon Code" autocomplete="off">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Cart Summary</h4>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium sub-total-price"></h6>
                        </div>

                        {{-- @if (session('discount_amount_price')) --}}
                        <div class="{{ session('discount_amount_price') ? 'd-flex' : 'd-none' }} justify-content-between">
                            <h6 class="font-weight-medium">Coupon </h6>
                            <h6 class="font-weight-medium coupon-div">
                                <span class="coupon-value">{{ session('discount_amount_price') }}</span>
                            </h6>
                        </div>
                        {{-- @endif --}}

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold final-price"></h5>
                        </div>
                        <a href="{{ route('cart.checkout') }}" class="btn btn-block btn-primary my-3 py-3">Order</a>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/cart/index.js')
@endsection
