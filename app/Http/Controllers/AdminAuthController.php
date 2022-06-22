<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        $credentials['role'] = 'admin';

        if (!auth()->attempt($credentials) ) {
            return back()->with('error', 'Email/Password is Incorrect');
        }
        return redirect('/'); 
    }

    /**
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return redirect('login');
    }
}
