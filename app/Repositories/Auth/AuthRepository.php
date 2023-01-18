<?php

namespace App\Repositories\Auth;

use App\Repositories\BaseRepository;
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
}
