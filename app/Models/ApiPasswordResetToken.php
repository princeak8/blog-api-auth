<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiPasswordResetToken extends Model
{
    use HasFactory;

    public static $PASSWORD_RESET_TOKEN = 10;
    public static $PASSWORD_VERIF_TOKEN = 20;
}
