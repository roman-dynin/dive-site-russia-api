<?php

namespace App\Http\Controllers\Web;

use Laravel\Socialite\Facades\Socialite;
use App\Http\Controllers\Controller;
use App\Models\User;

class AuthController extends Controller
{
    public function vkontakte()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    public function telegram()
    {
        return Socialite::driver('telegram')->redirect();
    }

    public function vkontakteCallback()
    {
        $user = Socialite::driver('vkontakte')->user();

        $user = User::query()
            ->where('oauth_provider', 'vkontakte')
            ->where('oauth_user_id', $user->getId())
            ->firstOrCreate([
                'oauth_provider' => 'vkontakte',
                'oauth_user_id'  => $user->getId(),
                'nickname'       => $user->getNickname(),
            ]);

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

        $token = auth()->login($user);

        $token = base64_encode($token);

        return redirect()->to(env('APP_FRONTEND_URL') . '?token=' . $token);
    }

    public function telegramCallback()
    {
        $user = Socialite::driver('telegram')->user();

        $user = User::query()
            ->where('oauth_provider', 'telegram')
            ->where('oauth_user_id', $user->getId())
            ->firstOrCreate([
                'oauth_provider' => 'telegram',
                'oauth_user_id'  => $user->getId(),
                'nickname'       => $user->getNickname(),
            ]);

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */

        $token = auth()->login($user);

        $token = base64_encode($token);

        return redirect()->to(env('APP_FRONTEND_URL') . '?token=' . $token);
    }
}
