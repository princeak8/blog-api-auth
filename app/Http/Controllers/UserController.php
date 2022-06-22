<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;

use Illuminate\Support\Facades\Validator;

use App\Services\UserService;

class UserController extends Controller
{

    private $userService;

    public function __construct()
    {
        $this->middleware('auth');
        $this->userService = new UserService;
    }

    public function register()
    {
        return view('register');
    }

    public function add_user(RegisterRequest $request)
    {
        try{
            $this->userService->save($request->validated());
            return redirect('users');
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('register')->with('error', $th->getMessage())->withInput();
        }
    }

    public function users()
    {
        try{
            $users = $this->userService->users();
            return view('users', compact('users'));
        }catch (\Throwable $th) {
            \Log::stack(['project'])->info($th->getMessage().' in '.$th->getFile().' at Line '.$th->getLine());
            return redirect('/')->with('error', $th->getMessage());
        }
    }
}
