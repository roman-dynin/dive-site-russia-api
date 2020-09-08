<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;

/**
 * Class AuthController.
 */
class AuthController extends BaseController
{
    /**
     * Получение пользователя.
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
