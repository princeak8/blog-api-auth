<?php

namespace App\Services;

use DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\User;

class UserService
{

    public function save($data)
    {
        $data['role'] = 'user';
        $data['password'] = bcrypt($data['password']);
        return User::create($data);
    }

    public function users()
    {
        return User::where('role', 'user')->get();
    }
    
}

?>