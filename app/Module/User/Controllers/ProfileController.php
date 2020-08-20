<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Models\Data\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * @var UserRepositoryInterface
     */
    private $repository;

    /**
     * ProfileController constructor.
     * @param UserRepositoryInterface $repository
     */
    public function __construct(UserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request)
    {
        return view('user::profile', ['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function changePassword(Request $request)
    {
        /* @var User $user */
        $user = Auth::user();
        if ($posts = $request->post()) {
            $validator = Validator::make($posts, [
                'current_password' => 'required|min:3|max:255',
                'password' => 'required|min:3|max:255',
                'retype_password' => 'required|min:3|max:255|same:password',
            ]);
            if ($validator->fails()) {
                return redirect()->route('user_profile')->withErrors($validator);
            }
            if (!Hash::check($posts['current_password'], $user->getAuthPassword())) {
                return redirect()->route('user_profile')->withErrors(__('Your current password is not correct'));
            }
            $user->setPassword(Hash::make($posts['password']));
            try {
                $this->repository->save($user);
            } catch (\Exception $e) {
                return redirect()->route('user_change_pwd')->withErrors($e->getMessage());
            }
            session()->flash('success', __('Password has been updated!'));
            return redirect()->route('user_profile');
        }
        return view('user::changepwd', ['user' => $user]);
    }
}
