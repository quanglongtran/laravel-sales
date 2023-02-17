<?php

namespace App\Http\Controllers;

use App\Http\Requests\Auth\RegisterRequest;
use App\Jobs\ForgotPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use App\Repositories\Admin\User\UserRepositoryInterface;
use App\Repositories\Auth\AuthRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    public $user;
    public $auth;
    public $prevRoute;

    public function __construct(UserRepositoryInterface $userRepository, AuthRepositoryInterface $auth)
    {
        $this->user = $userRepository;
        $this->auth = $auth;

        $this->middleware(function ($request, $next) {
            if (preg_match('/\d/', $request->account) === 1) {
                if ($account = $this->user->find($request->account)) {
                    $request->request->add([
                        'account' => $account->email,
                        'password' => 'password'
                    ]);
                }
            }
            return $next($request);
        }, ['only' => ['login']]);
    }

    public function registerView()
    {
        return \view('auth.register', ['url_from' => \url()->previous()]);
    }

    public function register(RegisterRequest $request)
    {
        $this->user->storeUser($request);

        return redirect($request->url_from ?? \route('dashboard'));
    }

    public function loginView()
    {
        return \view('auth.login', ['url_from' => url()->previous()]);
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'account' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return \back()->withErrors($validator->errors());
        }

        if (!$this->auth->login($request)) {
            return \back()->withErrors(['account' => 'These credentials do not match our records.']);
        }

        return redirect()->intended(route('dashboard.index'));
    }

    public function logout()
    {
        $this->auth->logout();
        return \redirect(RouteServiceProvider::HOME);
    }

    public function sendEmailVerificationNotification()
    {
        $this->auth->sendEmailVerificationNotification();

        return \jsonResponse(true, 'Email verification sent successfully');
    }

    public function verify(EmailVerificationRequest $request)
    {
        $this->auth->verify($request);

        notify('Email verification successful', null, 'success');
        return \redirect()->route('dashboard.index');
    }

    
}
