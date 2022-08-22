<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;

use App\Http\Resources\UserResource;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request){
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'user';
        if (! $token = auth()->attempt($credentials)) {
            return response()->json([
                'statusCode' => 401,
                'error' => 'Wrong Username or Password'
            ], 401);
        }
        $user = new UserResource(auth::user());
        return response()->json([
            'statusCode' => 200,
            'data' => [
                'token' => $token,
                'token_type' => 'bearer',
                'token_expires_in' => auth::factory()->getTTL() * 60, 
                'user' => $user
            ]
        ], 200);
    }
}
