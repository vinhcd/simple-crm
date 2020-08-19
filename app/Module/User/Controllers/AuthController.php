<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Block\UserEdit;
use App\Module\User\Block\UserList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

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

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function login(Request $request)
    {
        if ($request->post()) {
            $credentials = $request->only('email', 'password');
            if (Auth::attempt($credentials)) {
                return redirect()->intended('/');
            } else {
                return redirect()->route('login')->withErrors(__('Invalid email or password!'));
            }
        }
        return view('user::login');
    }

    /**
     * @return View
     */
    public function logout()
    {
        Auth::logout();

        return view('user::login');
    }

    /**
     * @todo: paging on server side
     * @return View
     */
    public function list()
    {
        $users = $this->repository->getBuilder()
            ->with('info')
            ->with('groups')
            ->with('departments')
            ->where('deleted', 0)
            ->get();
        $userListBlock = new UserList($users);

        return view('user::user_list', ['userListBlock' => $userListBlock]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     * @throws \Exception
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $user = $id ? $this->repository->getById($id) : $this->repository->create();
        $userEditBlock = new UserEdit($user);
        if ($posts = $request->post()) {
            $validator = Validator::make($posts, [
                'name' => 'required|max:255',
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                return redirect()->route('user_create_update', ['id' => $id])->withErrors($validator);
            }
            try {
                $userEditBlock->updateUser();
            } catch (\Exception $e) {
                return redirect()->route('user_create_update', ['id' => $id])->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('User has been updated!'));

            return redirect()->route('user_list');
        }
        return view('user::user_create', ['userEditBlock' => $userEditBlock]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->repository->getById($id);
        try {
            $this->repository->delete($user);
        } catch (\Exception $e) {
            return redirect()->route('user_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('User has been removed!'));

        return redirect()->route('user_list');
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function recover($id)
    {
        try {
            $this->repository->recover($id);
        } catch (\Exception $e) {
            return redirect()->intended('user_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('User has been recovered!'));
        return redirect()->route('user_list');
    }
}
