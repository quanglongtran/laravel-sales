<?php

namespace App\Repositories\Auth;

use App\Models\SocialAccount;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialRepository extends AuthRepository implements SocialRepositoryInterface
{
    public function getUrlProvider($provider)
    {
        return Socialite::driver($provider)->with(["prompt" => "select_account"])->redirect()->getTargetUrl();
    }

    public function handleProviderCallback($provider)
    {
        try {
            $driver = Socialite::driver($provider);
            return $this->createOrGetUser($driver);
        } catch (\Exception $e) {
            return null;
        }
    }

    public function createOrGetUser($provider)
    {
        $providerUser = $provider->user();
        $providerName = class_basename($provider);

        $account = SocialAccount::whereProvider($providerName)
            ->whereProviderUserId($providerUser->getId())
            ->first();

        if ($account) {
            return $account->user;
        } else {
            $account = new SocialAccount([
                'provider_user_id' => $providerUser->getId(),
                'provider' => $providerName,
                'token' => $providerUser->token,
            ]);

            $user = User::whereEmail($providerUser->getEmail())->first();

            if (!$user) {
                $user = $this->register([
                    'email' => $providerUser->getEmail(),
                    'name' => $providerUser->getName(),
                    'avatar' => $providerUser->getAvatar(),
                    'password' => \bcrypt('temporary')
                ], !optional($user)->hasVerifiedEmail());

                $user->set_new_password = true;
            }

            $account->user()->associate($user);
            $account->save();

            return $user;
        }
    }
}
