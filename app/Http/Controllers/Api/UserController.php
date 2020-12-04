<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use Tochka\JsonRpc\Traits\JsonRpcController;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Api
 */
class UserController
{
    use JsonRpcController;

    /**
     * Регистрация.
     *
     * @return array
     *
     * @throws InvalidParametersException
     */
    public function signup()
    {
        $data = $this->validateAndFilter([
            /*
            'nickname' => [
                'string',
                'required',
                Rule::unique('users')->where(function (Builder $query) {
                    $query->whereNull('oauth_provider');

                    return $query;
                }),
            ],
            */
            'phone' => [
                'string',
                'required',
                'unique:users',
            ],
            'password' => [
                'string',
                'required',
            ],
        ]);

        $user = new User();

        $user->fill($data);

        $user->save();

        return [
            'user' => $user,
        ];
    }
}
