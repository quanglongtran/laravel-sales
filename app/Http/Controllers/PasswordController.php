<?php

namespace App\Http\Controllers;

use App\Repositories\Auth\PasswordRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PasswordController extends Controller
{
    protected $password;
    
    public function __construct(PasswordRepositoryInterface $password)
    {
        $this->password = $password;
    }
    
    public function forgotPasswordView()
    {
        return \view('auth.passwords.forgot');
    }

    public function forgotPasswordHandle(Request $request)
    {
        $this->password->forgotPasswordHandle($request);

        \notify('Sent email successfully');
        return \back();

    }

    public function resetPasswordView(Request $request)
    {
        $table = DB::table('password_resets')->where('token', $request->token)->first();
        if (!$table) {
            return abort(404, 'Not found');
        }

        $isExpired = (new Carbon($table->created_at))->diffInDays(now()) > 0;
        if ($isExpired) {
            return abort(403, 'This link has expired');
        }
        
        return \view('auth.passwords.reset', [
            'token' => $request->token
        ]);
    }

    public function updatePassword(Request $request)
    {
        $this->password->updatePassword($request);

        \notify('Reset password successfully');
        return \redirect()->route('dashboard.index');
    }
}
