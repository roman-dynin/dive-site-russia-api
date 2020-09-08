<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\BaseController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;

/**
 * Class AuthController.
 */
class AuthController extends BaseController
{
    /**
     * Вход через ВКонтакте.
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function vkontakte()
    {
        return Socialite::driver('vkontakte')->redirect();
    }

    /**
     * Вход через ВКонтакте.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function vkontakteCallback()
    {
        $user = Socialite::driver('vkontakte')->user();

        $user = User::query()
            ->where('oauth_provider', 'vkontakte')
            ->where('oauth_user_id', $user->getId())
            ->firstOrCreate([
                'oauth_provider' => 'vkontakte',
                'oauth_user_id'  => $user->getId(),
                'username'       => $user->getNickname(),
            ]);

        /**
         * @var \Illuminate\Contracts\Auth\Authenticatable $user
         */
        $token = auth()->login($user);

        $token = base64_encode($token);

        return redirect()->to(env('APP_FRONTEND_URL').'?token='.$token);
    }
}
