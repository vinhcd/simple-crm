<?php

namespace App\Http\Controllers\Admin;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

/**
 * Class AuthController
 * @package App\Http\Controllers\Admin
 *
 * @TODO: this is coarse grained class
 */
class AuthController extends \App\Http\Controllers\Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            return redirect()->intended('/admin');
        }

        return view('admin.login');
    }

    public function logout()
    {
        Auth::logout();

        return view('admin.login');
    }

    public function list()
    {
        $users = User::all();

        return view('admin.list_user', ['users' => $users, 'username' => Auth::user()->name]);
    }

    public function create(Request $request)
    {
        if ($posts = $request->post()) {
            $user = new User();
            $user->name = $posts['name'];
            $user->email = $posts['email'];
            $user->password = Hash::make($posts['password']);
            $user->role_id = 1;
            $user->save();

            return redirect()->intended('/admin');
        }

        return view('admin.create_user');
    }

    public function changePwd(Request $request)
    {

    }
}
