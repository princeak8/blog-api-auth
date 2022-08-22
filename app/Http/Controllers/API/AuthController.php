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
        try{
            $post = $request->all();
            if(isset($post['domain_name'])) {
                $credentials = $request->only('email', 'password');
                $credentials['role'] = 'user';
                if (! $token = auth()->attempt($credentials)) {
                    return response()->json([
                        'statusCode' => 401,
                        'error' => 'Wrong Username or Password'
                    ], 401);
                }
                dd(auth::user()->domain_name." == ".$post['domain_name']);
                if(auth::user()->domain_name == $post['domain_name']) { 
                    //The domain name where the request was sent has to match with the registered domain name of the blog for security reasons
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
                }else{
                    return response()->json([
                        'statusCode' => 500,
                        'message' => 'The domain name does not match what was registered'
                    ], 500);
                }
            }else{
                return response()->json([
                    'statusCode' => 500,
                    'message' => 'Domain Name is not set'
                ], 500);
            }
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured while trying to perform this operation, Please try again later or contact support'
            ], 500);
        }
    }
}
