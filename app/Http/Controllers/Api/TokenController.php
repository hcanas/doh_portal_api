<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Login;
use App\Models\User;

class TokenController extends Controller
{
    /**
     * Attempt to generate an access token.
     *
     * @param Login $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(Login $request)
    {
        return response()->json(User::where('username', $request->validated()['username'])
            ->first()
            ->createToken($request->validated()['username'])
            ->plainTextToken
        );
    }
}
