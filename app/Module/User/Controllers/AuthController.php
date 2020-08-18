<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;

use App\Module\User\Models\Data\User;
use App\Module\User\Models\Data\UserInfo;
use App\Module\User\Models\UserRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class AuthController extends Controller
{
    /**
     * @var UserRepositoryInterface|UserRepository
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
            ->get();
        $userData = [];
        /* @var User $user */
        foreach ($users as $user) {
            $userData[$user->getId()] = [
                'id' => $user->getId(),
                'full_name' => $user->getFirstName() . ' ' . $user->getLastName(),
                'email' => $user->getEmail(),
                'phone' => $user->info ? $user->info->getPhone() : '',
                'groups' => implode(',', array_map(function ($group) {
                    return $group['display_name'];
                }, $user->groups->toArray())),
                'departments' => implode(',', array_map(function ($department) {
                    return $department['display_name'];
                }, $user->departments->toArray())),
            ];
        }
        return view('user::user_list', ['users' => $userData]);
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
        $userData['id'] = $user->getId();
        $userData['name'] = $user->getName();
        $userData['email'] = $user->getEmail();
        $userData['first_name'] = $user->getFirstName();
        $userData['last_name'] = $user->getLastName();
        /* @var UserInfo $info */
        $info = $user->getInfo();
        $userData['phone'] = $info->getPhone();
        $userData['birthday'] = $info->getBirthday();
        $userData['address'] = $info->getAddress();
        $userData['description'] = $info->getDescription();

        if ($posts = $request->post()) {
            $validator = Validator::make($posts, [
                'name' => 'required|max:255',
                'email' => 'required|email',
            ]);
            if ($validator->fails()) {
                return redirect()->route('user_create_update', ['id' => $userData['id']])->withErrors($validator);
            }
            $user->setName($posts['name']);
            $user->setFirstName($posts['first_name']);
            $user->setLastName($posts['last_name']);
            $user->setEmail($posts['email']);
            if (empty($user->getId())) {
                $user->setPassword(
                    Hash::make(substr(str_shuffle(str_repeat($x='0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil(10/strlen($x)) )),1,10))
                );
            }
            try {
                $this->repository->save($user);
            } catch (\Exception $e) {
                return redirect()->route('user_create_update', ['id' => $userData['id']])->withErrors($e->getMessage());
            }
            $info->setUserId($user->getId());
            $info->setPhone($posts['phone']);
            $info->setBirthday($posts['birthday']);
            $info->setAddress($posts['address']);
            $info->setDescription($posts['description']);
            $info->save();

            $request->session()->flash('success', __('User has been updated!'));
            return redirect()->route('user_list');
        }
        return view('user::user_create', ['user' => $userData]);
    }
}
