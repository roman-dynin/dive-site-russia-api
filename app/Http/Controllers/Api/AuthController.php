<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

/**
 * Class AuthController
 *
 * @package App\Http\Controllers\Api
 */
class AuthController extends BaseController
{
    /**
     * Получение пользователя
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getUser()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
        ]);
    }
}
