<?php

namespace App\Http\Controllers\Authorization;

use App\Data\LoginUserData;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginUserRequest;

class LoginController extends Controller
{
    public function __invoke(LoginUserRequest $request): JsonResponse {

        if (!Auth::attempt(LoginUserData::from($request->validated())->toArray())) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }

        $token = Auth::user()->createToken('API Token');

        $token->accessToken->forceFill([
            'expires_at' => now()->addMinutes(15),
        ])->save();

        return response()->json(['token' => $token->plainTextToken]);
    }
}