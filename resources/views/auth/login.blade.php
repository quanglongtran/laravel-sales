@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Login') }}</div>

                    <div class="card-body">
                        <form method="POST" action="{{ route('login') }}">
                            @csrf

                            <div class="row mb-3">
                                <label for="account"
                                    class="col-md-4 col-form-label text-md-end">{{ __('Email Or phone number') }}</label>

                                <div class="col-md-6">
                                    <input id="account" type="text"
                                        class="form-control @error('account') is-invalid @enderror" name="account"
                                        value="{{ old('account') }}" autocomplete="off" autofocus>

                                    @error('account')
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
                                        autocomplete="current-password">

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4 d-flex">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="remember" id="remember"
                                            {{ old('remember') ? 'checked' : '' }}>

                                        <label class="form-check-label" for="remember">
                                            {{ __('Remember Me') }}
                                        </label>
                                    </div>

                                    @if (Route::has('password.request'))
                                        <a class="btn btn-link ms-auto td-none" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-md-6 offset-md-4 text-center">
                                    <button type="submit" class="btn btn-primary">
                                        {{ __('Login') }}
                                    </button>

                                    {{-- <a href="#" style="display: block">
                                        <img src="{{asset('images/github.png')}}" alt="github">
                                        <span>Sign in with Github</span>
                                    </a> --}}
                                </div>
                            </div>

                            <div class="row mb-0">
                                <div class="col-md-6 offset-md-4 text-center">
                                    <p class="mb-3">Don't have an account yet? <a href="{{url('register')}}" class="td-none">Register now</a></p>
                                    <div>Sign in with</div>
                                    <div class="group-btn">
                                        <a href="{{url('login/google')}}" class="btn btn-social">
                                            <img src="{{asset('images/google.png')}}" alt="Google">
                                            Google
                                        </a>
                                        <a href="{{url('login/github')}}" class="btn btn-social">
                                            <img src="{{asset('images/github.png')}}" alt="Github" style="width: 24px;">
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
            box-shadow: inset  0 0 3px rgb(0,0,0);
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