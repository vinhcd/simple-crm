<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * AuthController constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

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
        $users = $this->repository->getAll();

        return view('user::user_list', ['users' => $users]);
    }

    public function createOrUpdate(Request $request)
    {
        if ($posts = $request->post()) {
            $user = $this->repository->create();
            $user->setName($posts['name']);
            $user->setEmail($posts['email']);
            $user->setPassword(Hash::make($posts['password']));
            $this->repository->save($user);

            return redirect()->route('user_list');
        }

        return view('user::user_create');
    }
}
