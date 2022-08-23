<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\Notifications\APIPasswordResetNotification;

use App\Services\AuthService;
use App\Services\UserService;

use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\ValidateEmailRequest;
use App\Http\Requests\ValidateTokenRequest;

use App\Http\Resources\UserResource;

class UserAuthController extends Controller
{
    private $error;
    private $authService;
    private $userService;

    function __construct(UserService $_userService) {
        $this->authService = new AuthService;
        $this->userService =  $_userService;
    }

    public function login(Request $request)
    {
        try{
            $post = $request->all();
            if(isset($post['domain_name'])) {
                $credentials = $request->only('email', 'password');
                $credentials['role'] = 'user';

                if (!$token = auth('api')->attempt($credentials) ) {
                    return response()->json([
                        'statusCode' => 401,
                        'error' => 'Wrong Username or Password'
                    ], 401);
                }
                //dd(auth('api')->user());
                if('admin.'.auth('api')->user()->domain_name == $post['domain_name']) { 
                    //The domain name where the request was sent has to match with the registered domain name of the blog for security reasons
                    $user = new UserResource(auth('api')->user());
                    return response()->json([
                        'statusCode' => 200,
                        'data' => [
                            'token' => $token,
                            'token_type' => 'bearer',
                            'token_expires_in' => auth('api')->factory()->getTTL() * 60, 
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

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        try{
            return $this->createNewToken(auth::refresh());
        }catch(\Exception $e){
            \Log::stack(['project'])->info($e->getMessage().' in '.$e->getFile().' at Line '.$e->getLine().' ActiveUser: '.auth::user());
            return response()->json([
                'statusCode' => 500,
                'message' => 'An error occured while trying to perform this operation, Please try again later or contact support'
            ], 500);
        }
    }

    /**
     * send password reset code 
     *
     * @param array request of email
     * 
     * @return Array 
     *
     */
    public function sendPasswordResetToken(ValidateEmailRequest $request)
    {
        $data = $request->all();
        try{
            $user = $this->userService->getUserByEmail($data["email"]);
            if($user) {
                $token = $this->authService->genResetCode($user->id);
                $apiPasswordResetToken = $this->authService->savePasswordResetToken($user, $token);
                if($apiPasswordResetToken) {
                    $user->notify(new APIPasswordResetNotification($token));
                    return response()->json([
                        'statusCode' => 200,
                        'message' => 'A password reset code has been sent to your mail'
                    ], 200);
                }else{
                    return response()->json([
                        'statusCode' => 401,
                        'message' => "Token was not able to be saved.. please try again or contact the admin"
                    ], 401);
                }
            }
            $errorMsg = (!$user) ? 'Incorrect email' : 'Password reset process has already begun, Please check your mail for your password reset code';
            return response()->json([
                'statusCode' => 401,
                'message' => $errorMsg
            ], 401);
        }catch(\Exception $e){
            if(isset($apiPasswordResetToken)) $apiPasswordResetToken->delete();
            throw $e;
        }
    }

    //Validates the reset code that the user submits and sends back a token if successful
    public function validatePasswordResetToken(ValidateTokenRequest $request)
    {
        $data = $request->all();
        try{
            $res = $this->authService->validationPasswordResetToken($data);
            if($res['token']) {
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Code verified successfully',
                    'token' => $res['token']
                ], 200);
            }else{
                return response()->json([
                    'statusCode' => 422,
                    'message' => $res['error']
                ], 422);
            }
        }catch(\Exception $e){
            throw $e;
        }
    }

    // validates the token sent with the new password and changes the password
    public function setNewAccountPassword(ChangePasswordRequest $request)
    {
        $data = $request->all();
        try{
            $res = $this->authService->validatePasswordVerifToken($data);
            if($res['token']) {
                $user = $this->userService->getUserById($res['token']->user_id);
                $user->password = bcrypt($data['password']);
                $user->save();
                $this->authService->clearTokens($res['token']);
                return response()->json([
                    'statusCode' => 200,
                    'message' => 'Operation Successfull'
                ], 200);
            }
            return response()->json([
                'statusCode' => 422,
                'message' => $res['error']
            ], 422);
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function apiPasswordTokens()
    {
        try{
            $tokens = $this->authService->apiPasswordTokens();
            return response()->json([
                'statusCode' => 200,
                'data' => $tokens
            ], 200);
        }catch(\Exception $e){
            throw $e;
        }
    }

    public function deleteAPITokens()
    {
        try{
            $this->authService->deleteApiPasswordTokens();
            return response()->json([
                'statusCode' => 200,
                'message' => 'deleted'
            ], 200);
        }catch(\Exception $e){
            throw $e;
        }
    }
}
