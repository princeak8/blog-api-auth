<?php

namespace App\Services;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

use App\Helpers\Helper;

use App\Models\User;
use App\Models\ApiPasswordResetToken;

class AuthService
{

    public function genResetCode($user_id)
    {
        do{
            $token = '';
            for($i=0; $i<4; $i++) {
                $token .= mt_rand(0, 9);
            }
            $signature = hash('md5', $token);
            $exists = $this->getTokenByUserIdSignature($user_id, $signature);
        } while ($exists);
        return $token;
    }

    public function checkIfPasswordResetProcessIsOnGoing($user_id)
    {
        $tokens = ApiPasswordResetToken::where('user_id', $user_id)->get();
        $onGoing = false;
        if($tokens && $tokens->count() > 0) {
            foreach($tokens as $token) {
                // if(Carbon::now()->lessThan($token->expires_at)) {
                //     $onGoing = true;
                // }   
            }
        }
        return $onGoing;
    }

    /**
     * Validate the Alphanumeric code sent by the user
     *
     * @param array data of password reset token
     * 
     * @return Array
     *
     */
    public function validationPasswordResetToken($data)
    {
        //dd(hash('md5', $data['password_reset_code']));
            $resetToken = ApiPasswordResetToken::where('token_signature', hash('md5', $data['password_reset_code']))
                                                ->where('token_type', APIPasswordResetToken::$PASSWORD_RESET_TOKEN)
                                                ->first();
            if(!$resetToken) {
                return [
                    'error' => "Invalid password reset code",
                    'token' => false
                ]; 
            }
            if(Carbon::now()->greaterThan($resetToken->expires_at)) {
                return [
                    'error' => "The Password reset code given has expired",
                    'token' => false
                ];
            }

            $token = $this->genResetCode($resetToken->user_id);
            $signature = hash('md5', $token);
            
            $verifToken = new ApiPasswordResetToken;
            $verifToken->user_id = $resetToken->user_id;
            $verifToken->token_signature = $signature;
            $verifToken->used_token = $resetToken->id;
            $verifToken->token_type = ApiPasswordResetToken::$PASSWORD_VERIF_TOKEN;
            $verifToken->expires_at = Carbon::now()->addMinutes(30);
            $verifToken->save();

            $resetToken->expires_at = Carbon::now();
            $resetToken->update();
            return [
                "token" => $token
            ];
    }

    /**
     * Validate the new Password Verif token
     *
     * @param array data of password verif token
     * 
     * @return Array
     *
     */
    public function validatePasswordVerifToken($data)
    {
            $verifToken = ApiPasswordResetToken::where('token_signature', hash('md5', $data['token']))
                                                ->where('token_type', APIPasswordResetToken::$PASSWORD_VERIF_TOKEN)
                                                ->first();
            if(!$verifToken) {
                return [
                    'error' => "The Token is invalid or has been used",
                    'token' => false
                ]; 
            }
            if(Carbon::now()->greaterThan($verifToken->expires_at)) {
                return [
                    'error' => "The Password reset code given has given has expired",
                    'token' => false
                ];
            }
            $user = User::find($verifToken->user_id);
            if($user && $user->email_verified == 0) {
                $user->email_verified = 1;
                $user->update();
            }
            return [
                'token' => $verifToken
            ];
    }

    public function clearTokens($token)
    {
        $resetToken = ApiPasswordResetToken::findOrFail($token->used_token);
        //delete password reset token
        $resetToken->delete();
        //delete password verif token
        $token->delete();
    }

    public function clearUserTokens($user_id)
    {
        $resetTokens = ApiPasswordResetToken::where('user_id', $user_id)->get();
        if($resetTokens->count() > 0) {
            foreach($resetTokens as $resetToken) {
                $resetToken->delete();
            }
        }
    }

    public function getTokenByUserIdSignature($user_id, $signature)
    {
        return ApiPasswordResetToken::where('user_id', $user_id)->where('token_signature', $signature)->first();
    }

    public function savePasswordResetToken($user, $token)
    {
            $this->clearUserTokens($user->id);
            $signature = hash('md5', $token);
            // $resetToken = ApiPasswordResetToken::where('user_id', $user->id)->first();
            // if(!$apiPasswordResetToken) {;
            //     $apiPasswordResetToken = new ApiPasswordResetToken;
            // }
            $apiPasswordResetToken = new ApiPasswordResetToken;
            $apiPasswordResetToken->user_id = $user->id;
            $apiPasswordResetToken->token_signature = $signature;
            $apiPasswordResetToken->expires_at = Carbon::now()->addMinutes(30);
            $apiPasswordResetToken->save();
            return $apiPasswordResetToken;
    }

    public function savePasswordVerifToken($user, $token)
    {
            $apiPasswordResetToken = ApiPasswordResetToken::create([
                "user_id" => $token->user_id,
                "token_signature" => hash('md5', $token),
                "used_token" => $token->id,
                "token_type" => ApiPasswordResetToken::$PASSWORD_VERIF_TOKEN,
                "expires_at" => Carbon::now()->addMinutes(30),
            ]);
        return $apiPasswordResetToken;
    }

    public function apiPasswordTokens()
    {
        return ApiPasswordResetToken::all();
    }

    public function deleteApiPasswordTokens()
    {
        $tokens = $this->apiPasswordTokens();
        if($tokens->count() > 0) {
            foreach($tokens as $token) {
                $token->delete();
            }
        }
    }
    
}

?>