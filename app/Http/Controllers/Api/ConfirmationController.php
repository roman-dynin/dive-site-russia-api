<?php

namespace App\Http\Controllers\Api;

use App\Models\Confirmation;
use Tochka\JsonRpc\Exceptions\JsonRpcException;
use Tochka\JsonRpc\Exceptions\RPC\InvalidParametersException;
use Tochka\JsonRpc\Traits\JsonRpcController;

/**
 * Class UserController.
 *
 * @package App\Http\Controllers\Api
 */
class ConfirmationController
{
    use JsonRpcController;

    /**
     * Создание подтверждения.
     *
     * @return array
     *
     * @throws InvalidParametersException|JsonRpcException
     */
    public function createConfirmation()
    {
        $data = $this->validateAndFilter([
            'phone' => [
                'string',
                'required',
            ],
        ]);

        $confirmation = new Confirmation();

        $confirmation->fill($data);

        $confirmation->code = 12345; // TODO: Случайный числовой код подтверждения

        $status = $confirmation->send();

        if ($status) {
            $confirmation->save();

            $confirmation->refresh();

            return [
                'confirmation' => $confirmation,
            ];
        }

        throw new JsonRpcException(
            JsonRpcException::CODE_EXTERNAL_INTEGRATION_ERROR,
            'Не удалось отправить код подтверждения'
        );
    }
}
