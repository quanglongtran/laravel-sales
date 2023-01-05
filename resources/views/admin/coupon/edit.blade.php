@extends('admin.layouts.app')

@section('title', "Edit User $coupon->name")

@section('content')
    <div class="card">
        <h1>Edit coupon</h1>

        <div>
            <form action="{{ route('admin.coupon.update', $coupon->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="input-group input-group-static mb-4">
                    <label>Name</label>
                    <input type="text" class="form-control text-uppercase" name="name" autocomplete="off"
                        value="{{ old('name') ?? $coupon->name }}">

                    @error('name')
                        <div class="alert alert-danger text-white" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <div class="input-group input-group-static mb-4">
                    <label>Value</label>
                    <input type="number" class="form-control text-uppercase" name="value" autocomplete="off"
                        value="{{ old('value') ?? $coupon->value }}">

                    @error('value')
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
                    <input type="date" class="form-control" name="expired"
                        value="{{ old('expired') ?? $coupon->expired }}">
                </div>

                <button type="submit" class="btn btn-submit btn-primary">Update</button>
            </form>
        </div>
    </div>
@endsection
