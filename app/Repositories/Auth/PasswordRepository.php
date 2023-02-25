<?php

namespace App\Repositories\Auth;

use App\Jobs\ForgotPassword;
use App\Jobs\VerifyEmail;
use App\Models\PasswordReset;
use App\Models\User;
use App\Repositories\BaseRepository;
use App\Repositories\User\UserRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PasswordRepository extends AuthRepository implements PasswordRepositoryInterface
{

    public function forgotPasswordHandle($request)
    {
        $request->validate([
            'email' => 'required|email'
        ]);
        
        $user = $this->model->where('email', $request->email)->first();

        if (!$user) {
            \notify('Your email address does not exist', null, 'error');
            return \back()->withErrors(['email' => 'Your email address does not exist']);
        }

        $token = Str::random(15);
        DB::table('password_resets')->updateOrInsert(['email' => $user->email], ['token' => $token, 'created_at' => \now()]);
        $url = URL::signedRoute('password.callback', ['token' => $token]);

        ForgotPassword::dispatch(['user' => $user, 'url' => $url]);

    }

    public function updatePassword($request)
    {
        $request->validate([
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);
        
        $table = PasswordReset::whereToken($request->token)->first();
        if (!$table) {
            return \abort(403, 'You have not permissions to change');
        }
        
        $user = User::where(['email' => $table->email])->first();
        $user->update(['password' => bcrypt($request->password)]);
        // $user = User::where('email', $table->email)->first();
        // $user = $this->update($user->id, ['password' => bcrypt($request->password)]);
        $table->delete();
        return $user;
    }
}
