<?php

namespace App\Http\Controllers\Api;

class AuthController
{
    public function getUser()
    {
        $user = auth()->user();

        return response()->json([
            'user' => $user,
        ]);
    }
}
