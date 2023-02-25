<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\SocialRepositoryInterface;
use App\Services\SocialAccountService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    protected $social;
    
    public function __construct(SocialRepositoryInterface $social)
    {
        $this->social = $social;
    }
    
    public function redirectToProvider($provider)
    {
        return redirect($this->social->getUrlProvider($provider));
    }

    public function handleProviderCallback($provider)
    {
        $user = $this->social->handleProviderCallback($provider);
        
        if (!$user) {
            \notify('Login with '.ucfirst($provider).' failed. Please try again.', null, 'error');
            return \redirect()->route('login');
        }
        
        if (!$user->set_new_password) {
            Auth::login($user);
            unset($user->set_new_password);
            return \redirect()->route('dashboard.index');
        }
        
        $token = ['token' => Str::random(15)];
        DB::table('password_resets')->updateOrInsert(['email' => $user->email], $token);

        return view('auth.confirm-password', $token); 
    }
}
