@extends('admin.layouts.app')

@section('title', 'Create Coupon')

@section('styles')
    <style>
        .radio-group {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
        }

        .form-check {
            padding: 0;
        }
    </style>
@endsection

@section('content')
    <div class="card">
        <h1>Create coupon</h1>

        <div>
            <form action="{{ route('admin.coupon.store') }}" method="POST">
                @csrf

                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Name</label>
                    <input type="text" class="form-control text-uppercase" name="name" autocomplete="off"
                        value="{{ old('name') }}">

                    @error('name')
                        <div class="w-100"></div>
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-outline mb-4">
                    <label class="form-label">Value</label>
                    <input type="text" class="form-control" name="value" autocomplete="off"
                        value="{{ old('value') }}">

                    @error('value')
                        <div class="w-100"></div>
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <h5>Select type</h5>
                <div class="radio-group mb-3">
                    <label class="form-check" style="margin-left: 0;">
                        <input class="form-check-input" type="radio" name="type" value="money" checked>
                        <span class="custom-control-label">Money</span>
                    </label>
                </div>

                <div class="input-group input-group-static my-3">
                    <label>Expired</label>
                    <input type="date" class="form-control" name="expired" {{ old('expired') }}>
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
