<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiPasswordResetToken extends Model
{
    use HasFactory;

    protected $table = "api_password_reset_token";
    public static $PASSWORD_RESET_TOKEN = 10;
    public static $PASSWORD_VERIF_TOKEN = 20;
}
