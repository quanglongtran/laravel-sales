@extends('client.layouts.app')

@section('title', 'Cart page')

@php
    $user = auth()->user();
@endphp

@section('content')
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <form action="{{ route('cart.checkout-handle') }}" method="POST" class="order-form">
                    @csrf
                    <div class="row">
                        <div class="col-md-6 form-group">
                            <label>Name</label>
                            <input class="form-control" value="{{ old('customer_name') ?? $user->name }}" name="customer_name"
                                type="text" placeholder="John">
                            @error('customer_name')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()


                        </div>

                        <div class="col-md-6 form-group">
                            <label>E-mail</label>
                            <input class="form-control" name="customer_email"
                                value="{{ old('customer_email') ?? $user->email }}" type="text"
                                placeholder="example@email.com">
                            @error('customer_email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()


                        </div>

                        <div class="col-md-6 form-group">
                            <label>Phone Number</label>
                            <input class="form-control" name="customer_phone"
                                value="{{ old('customer_phone') ?? $user->phone }}" type="text"
                                placeholder="+123 456 789">
                            @error('customer_phone')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()


                        </div>

                        <div class="col-md-6 form-group">
                            <label>Address </label>
                            <input class="form-control" name="customer_address"
                                value="{{ old('customer_address') ?? $user->address }}" type="text"
                                placeholder="123 Street">
                            @error('customer_address')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()


                        </div>

                        <div class="col-md-6 form-group">
                            <label>Note </label>
                            <input class="form-control" value="{{ old('note') }}" name="note" type="text"
                                placeholder="123 Street">
                            @error('note')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror ()


                        </div>
                    </div>
                </form>
            </div>


            <div class="col-lg-4">
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Order Total</h4>
                    </div>
                    <div class="card-body">
                        <h5 class="font-weight-medium mb-3">Products</h5>

                        @foreach ($cart->cartProducts as $cartProduct)
                            <div class="d-flex justify-content-between">
                                <p>{{ $cartProduct->product->name }} x {{ $cartProduct->product_quantity }}</p>
                                <p>{{ $cartProduct->product->price }}</p>

                            </div>
                        @endforeach

                        <hr class="mt-0">
                        <div class="d-flex justify-content-between mb-3 pt-1">
                            <h6 class="font-weight-medium">Subtotal</h6>
                            <h6 class="font-weight-medium total-price">{{ $cart->total_price }}</h6>

                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium shipping shipping-price">30000</h6>
                            <input type="hidden" value="20" name="ship">

                        </div>
                        @if (session('discount_amount_price'))
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Coupon </h6>
                                <h6 class="font-weight-medium coupon-div coupon-value"
                                    data-price="{{ session('discount_amount_price') }}">
                                    {{ session('discount_amount_price') }}</h6>
                            </div>
                        @endif

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <div class="d-flex justify-content-between mt-2">
                            <h5 class="font-weight-bold">Total</h5>
                            <h5 class="font-weight-bold total-price-all final-price"></h5>
                            <input type="hidden" id="total" value="" name="total">
                        </div>
                    </div>
                </div>
                <div class="card border-secondary mb-5">
                    <div class="card-header bg-secondary border-0">
                        <h4 class="font-weight-semi-bold m-0">Payment</h4>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <div class="custom-control custom-radio">
                                <input type="radio" class="custom-control-input" checked value="monney" name="payment">
                                <label class="custom-control-label">Money</label>
                            </div>
                        </div>

                    </div>
                    <div class="card-footer border-secondary bg-transparent">
                        <button
                            class="btn btn-lg btn-block btn-primary font-weight-bold my-3 py-3 btn-submit-order">Order</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    @vite('resources/js/client/cart/checkout.js')
@endsection
