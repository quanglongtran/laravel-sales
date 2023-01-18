<?php

namespace App\Repositories\Auth;

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
}
