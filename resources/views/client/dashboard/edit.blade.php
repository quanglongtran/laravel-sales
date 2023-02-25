@extends('client.dashboard.layout')
{{-- // color :#16C784 --}}
@php
    $user = $user ?? auth()->user();
@endphp

@section('styles')
@endsection

@section('content')
    @include('partials.preview-image')
    <h1 class="text-center">Edit</h1>
    <div id="url-edit-form" style="display: none">{{ route('dashboard.update', $user->id) }}</div>

    <div class="container-fluid" method="POST" action="{{ route('login') }}">

        <div class="row mb-3">
            <div class="col-md-4 offset-4">
                <form action="{{ route('dashboard.update', $user->id) }}" class="preview" style="width: 200px; height: 200px;"
                    default="{{ $user->image_path }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                </form>
            </div>
        </div>

        <div class="row
                    mb-3">
            <label for="name" class="col-md-3 col-form-label text-md-end">{{ __('Your name') }}</label>

            <div class="col-md-7">
                <form class="input-group edit-form" data-value="{{ $user->name }}">
                    <input id="name" type="text" class="form-control" name="name" value="{{ $user->name }}"
                        autocomplete="off">
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <label for="email" class="col-md-3 col-form-label text-md-end">{{ __('Your email') }}</label>

            <div class="col-md-7">
                <div class="input-group">
                    @if (!$user->hasVerifiedEmail())
                        <button class="btn btn-info" type="button" style="color: aliceblue" id="verify-email-btn"
                            data-url="{{ route('verification.send') }}">Verify</button>
                    @endif
                    <input id="email" type="text" disabled class="form-control @error('email') is-invalid @enderror"
                        name="email" value="{{ old('email') ?? $user->email }}" autocomplete="off">
                </div>

                @if ($user->hasVerifiedEmail())
                    <label for="address" class="col-form-label" style="color: #16C784">
                        {{ __('Your email has been verified') }}
                    </label>
                @endif
            </div>
        </div>

        <div class="row mb-3">
            <label for="phone" class="col-md-3 col-form-label text-md-end">{{ __('Your phone') }}</label>

            <div class="col-md-7">
                <form class="input-group edit-form" data-value="{{ $user->phone }}">
                    <input id="phone" type="text" class="form-control" name="phone" value="{{ $user->phone }}"
                        autocomplete="off">

                </form>
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-3 col-form-label text-md-end">{{ __('Your address') }}</label>

            <div class="col-md-7">
                <form class="input-group edit-form" data-value="{{ $user->address }}">
                    <textarea id="address" type="text" class="form-control" name="address" autocomplete="off">{{ $user->address }}</textarea>

                    @error('address')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                    @enderror
                </form>
            </div>
        </div>

        <div class="row mb-3">
            <label for="address" class="col-md-3 col-form-label text-md-end">{{ __('Your gender') }}</label>

            <div class="col-md-7 d-flex align-items-center">
                <div class="input-group">
                    <div class="form-check" style="margin-right: 4rem">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault1"
                            {{ $user->gender == 'male' ? 'checked' : '' }} value="male">
                        <label class="form-check-label" for="flexRadioDefault1">
                            Male
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="gender" id="flexRadioDefault2" value="female"
                            {{ $user->gender == 'female' ? 'checked' : '' }}>
                        <label class="form-check-label" for="flexRadioDefault2">
                            Female
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal title</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ...
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
    <script src="https://kit.fontawesome.com/b7bb695d24.js" crossorigin="anonymous"></script>
    @vite('resources/js/client/dashboard/edit.js')
    <script>
        appendPreviewFrame(document.getElementsByClassName('preview')[0], 'avatar');
    </script>
@endsection
