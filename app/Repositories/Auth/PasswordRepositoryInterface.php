<?php

namespace App\Repositories\Auth;

use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

interface PasswordRepositoryInterface
{    
    /**
     * forgotPasswordHandle
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function forgotPasswordHandle(Request $request);
    
    /**
     * updatePassword
     *
     * @param  \Illuminate\Http\Request $request
     * @return void
     */
    public function updatePassword(Request $request);
}
