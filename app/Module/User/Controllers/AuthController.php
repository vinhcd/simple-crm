<?php

namespace App\Module\User\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends \App\Http\Controllers\Controller
{
    public function login(Request $request)
    {
        if ($request->post()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('/');
            }
        }
        return view('user::login');
    }

    public function logout()
    {
        Auth::logout();

        return view('user::login');
    }

    public function list()
    {
        $users = User::all();

        return view('user::user_list', ['users' => $users]);
    }

    public function createOrUpdate(Request $request)
    {
        if ($posts = $request->post()) {
            $user = new User();
            $user->name = $posts['name'];
            $user->email = $posts['email'];
            $user->password = Hash::make($posts['password']);
            $user->role_id = 1;
            $user->save();

            return redirect()->route('user_list');
        }

        return view('user::user_create');
    }
}
