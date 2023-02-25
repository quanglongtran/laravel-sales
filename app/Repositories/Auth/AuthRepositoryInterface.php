<?php

namespace App\Repositories\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{    
    /**
     * register
     *
     * @param  array $request
     * @return \App\Models\User
     */
    public function register(array $attributes);
    
    /**
     * login
     *
     * @param  Request $request
     * @return void
     */
    public function login(Request $request);
    
    /**
     * logout
     *
     * @return void
     */
    public function logout();

    /**
     * sendEmailVerificationNotification
     *
     * @return void
     */
    public function sendEmailVerificationNotification();

    /**
     * verify
     *
     * @param \Illuminate\Foundation\Auth\EmailVerificationRequest $request
     * @return void
     */
    public function verify($request);
}
