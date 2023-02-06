<?php

namespace App\Repositories\Auth;

use App\Jobs\VerifyEmail;
use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class AuthRepository implements AuthRepositoryInterface
{
    public function login($request)
    {
        $isEmail = filter_var($request->account, \FILTER_VALIDATE_EMAIL);

        $condition[$isEmail ? 'email' : 'phone'] = $request->account;

        if (Auth::attempt(['password' => $request->password, ...$condition], $request->has('remember'))) {
            return Auth::user();
        }

        return \false;
    }

    public function logout()
    {
        Auth::logout();
    }

    public function sendEmailVerificationNotification()
    {
        VerifyEmail::dispatch(Auth::user());
    }

    public function verify($request)
    {
        $request->fulfill();
    }
}
