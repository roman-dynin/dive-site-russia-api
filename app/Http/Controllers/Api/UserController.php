<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Confirmation;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
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
     * @throws InvalidParametersException|JsonRpcException
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
            'confirmation_id' => [
                'numeric',
                'required',
                'exists:confirmations,id',
            ],
            'confirmation_code' => [
                'string',
                'required',
            ],
        ]);

        /** @var Confirmation $confirmation */
        $confirmation = Confirmation::query()->find($data['confirmation_id']);

        if ($confirmation->code !== $data['confirmation_code']) {
            throw new JsonRpcException(
                JsonRpcException::CODE_INVALID_PARAMETERS,
                'Неверный код подтверждения'
            );
        }

        $confirmation->delete();

        $user = new User();

        $user->fill($data);

        $user->save();

        return [
            'user' => $user,
        ];
    }
}
