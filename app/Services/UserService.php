<?php

namespace App\Services;

use DB;
use App\Exceptions\UserNotFoundException;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
//use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Helper;

use App\Models\User;

class UserService
{

    /**
     * gets a user by emali
     *
     * @param var email
     * 
     * @return \App\User A user object
     *
     */
    public function getUserByEmail($email)
    {
        return User::where('email', $email)->first();
            
    }

    /**
     * gets a user by id
     *
     * @param var id
     * 
     * @return \App\User A user object
     *
     */
    public function getUserById($id)
    {
        return User::find($id);
    }

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

    public function update($data, $user)
    {
        $user->domain_name = $data['domain_name'];
        $user->email = $data['email'];
        $user->update();
    }
    
}

?>