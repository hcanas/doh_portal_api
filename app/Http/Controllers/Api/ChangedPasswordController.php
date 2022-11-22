<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePassword;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ChangedPasswordController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function __invoke(ChangePassword $request)
    {
        try {
            $user = User::find(auth()->id());

            $user->fill(['password' => Hash::make($request->validated('new_password'))])
                ->save();

            return response()->json('', 204);
        } catch (\Exception $e) {
            logger($e);
            return response()->json('Unable to change password. Please try again later.', 500);
        }
    }
}
