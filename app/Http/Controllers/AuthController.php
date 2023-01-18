<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public $user;
    public $auth;
    public $prevRoute;

    public function __construct(UserRepositoryInterface $userRepository, AuthRepositoryInterface $auth)
    {
        $this->user = $userRepository;
        $this->auth = $auth;
    }

    public function register(RegisterRequest $request)
    {
        $this->user->storeUser($request);

        return \to_route('product.index');
    }

    public function loginView()
    {
        $this->prevRoute = \redirectPrevRoute();

        return \view('auth.login');
    }

    public function login(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password' => 'required',
        ]);

        // ['account' => 'These credentials do not match our records.']


        if ($validator->fails()) {
            return \back()->withErrors($validator->errors());
        }

        if (!$this->auth->login($request)) {
            return \back()->withErrors(['account' => 'These credentials do not match our records.']);
        }

        return \redirectPrevRoute();
    }

    public function logout()
    {
        $this->auth->logout();
        return redirectPrevRoute();
    }
}
