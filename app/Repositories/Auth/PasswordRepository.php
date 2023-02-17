<?php

namespace App\Repositories\Auth;

use App\Jobs\ForgotPassword;
use App\Jobs\VerifyEmail;
use App\Models\User;
use App\Repositories\BaseRepository;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;

class PasswordRepository extends BaseRepository implements PasswordRepositoryInterface
{
    public function getModel()
    {
        return User::class;
    }

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

        // return $request->all();

        $table = DB::table('password_resets')->where('token', $request->token);
        if (!$table->first()) {
            return \abort(403, 'You have not permissions to change');
        }
        
        DB::table('users')->where('email', $table->first()->email)->update(['password' => \bcrypt($request->password)]);
        $table->delete();
    }
}
