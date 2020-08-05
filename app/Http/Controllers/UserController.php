<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        //todo: auth based on organization id
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/');
        }

        return view('user.login');
    }
}
