<?php

namespace App\Repositories\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

interface AuthRepositoryInterface
{
    /**
     * login
     *
     * @param  Request $request
     * @return void
     */
    public function login(Request $request);

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
