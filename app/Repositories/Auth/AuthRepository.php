<?php

namespace App\Repositories\Auth;

use App\Jobs\VerifyEmail;
use App\Models\User;
use App\Repositories\BaseRepository;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Support\Facades\Auth;

class AuthRepository extends BaseRepository implements AuthRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }
    
    public function register($attributes, $isVerified = false)
    {
        /**
         * @var \App\Models\User $user
         */
        $user = $this->create($attributes);
        $user->images()->create(['url' => $attributes['avatar']]);

        if ($isVerified) {
            $user->markEmailAsVerified();
        }
        
        return $user;
    }
    
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
