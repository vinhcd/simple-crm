<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Block\UserEdit;
use App\Module\User\Block\UserList;
use App\Module\User\Models\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * @var UserRepository
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
     * @todo: lock user after X times failed
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function login(Request $request)
    {
        if ($request->post()) {
            $credentials = $request->only('name', 'password');
            if (Auth::attempt($credentials, $request->post('remember') == 'on')) {
                return redirect()->intended('/');
            } else {
                return redirect()->route('login')->withErrors(__('Invalid account or password!'));
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
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|View
     */
    public function resetPassword(Request $request, $id)
    {
        $user = $this->repository->getById($id);
        if ($posts = $request->post()) {
            $request->validate([
                'password' => 'required|min:3|max:255',
                'retype_password' => 'required|min:3|max:255',
            ]);
            if ($user->getId() == Auth::id()) redirect()->back()->withErrors(__('You cannot reset yourself'));
            $user->setPassword(Hash::make($posts['password']));
            try {
                $this->repository->save($user);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->route('user_list')->withErrors($e->getMessage());
            }
            session()->flash('success', __('Password has been updated!'));
            return redirect()->route('user_list');
        }
        return view('user::resetpwd', ['user' => $user]);
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
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $user = $id ? $this->repository->getById($id) : $this->repository->create();

        $userEditBlock = new UserEdit($user);
        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'phone' => 'numeric|nullable',
                'birthday' => 'date:Y-m-d|nullable',
            ]);
            try {
                $userEditBlock->updateUser();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors($e->getMessage())->withInput();
            }
            $request->session()->flash('success', __('User :user has been updated!', ['user' => $user->getFullName()]));

            return  redirect()->route('user_list');
        }
        return view('user::user_edit', ['userEditBlock' => $userEditBlock]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $user = $this->repository->getById($id);
        try {
            if ($user->getId() == Auth::id()) throw new \Exception(__('You cannot remove yourself'));
            $this->repository->delete($user);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('user_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('User :user has been removed!', ['user' => $user->getFullName()]));

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
            Log::error($e->getMessage());
            return redirect()->intended('user_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('User has been recovered!'));

        return redirect()->route('user_list');
    }
}
