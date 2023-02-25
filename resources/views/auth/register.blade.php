@extends('layouts.app')

@section('content')
    @include('partials.preview-image')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Register') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data">
                            @csrf

                            <div class="row mb-3 justify-content-center">
                                <div class="preview col-auto" style="width: 200px; height: 200px; border-radius: 50%"></div>
                            </div>

                            <div class="row mb-3">
                                <label for="name"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>

                                <div class="col-md-6">
                                    <input id="name" type="text"
                                        class="form-control @error('name') is-invalid @enderror" name="name"
                                        value="{{ old('name') }}" required autocomplete="off" autofocus>

                                    @error('name')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Address') }}</label>

                                <div class="col-md-6">
                                    <input id="email" type="email"
                                        class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" required autocomplete="off">

                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="email"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="phone" type="text"
                                        class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        value="{{ old('phone') }}" required autocomplete="off">

                                    @error('phone')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required autocomplete="off" value="password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label for="password-confirm"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Confirm Password') }}</label>

                                <div class="col-md-6">
                                    <input id="password-confirm" type="password" class="form-control"
                                        name="password_confirmation" required autocomplete="off" value="password">
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Register') }}
                                    </button>
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-center">
                                    <p class="mb-3">Already have an account? <a href="{{ url('login') }}"
                                            class="td-none">Login now</a></p>
                                    <div>Sign in with</div>
                                    <div class="group-btn">
                                        <a href="{{ url('login/google') }}" class="btn btn-social">
                                            <img src="{{ asset('images/google.png') }}" alt="Google">
                                            Google
                                        </a>
                                        <a href="{{ url('login/github') }}" class="btn btn-social">
                                            <img src="{{ asset('images/github.png') }}" alt="Github"
                                                style="width: 24px;">
                                            Github
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        appendPreviewFrame(document.getElementsByClassName('preview')[0], 'avatar', 'Select an avatar');
    </script>
@endsection

@section('styles')
    <style>
        .group-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
        }

        .btn-social {
            border: 1px solid #ccc;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 4px;
        }

        .btn-social:hover {
            background-color: #ECECEF;
            box-shadow: inset 0 0 3px rgb(0, 0, 0);
        }

        .btn-social img {
            width: 18px;
        }

        .td-none {
            text-decoration: none;
        }

        .td-none:hover {
            text-decoration: underline;
        }
    </style>
@endsection
