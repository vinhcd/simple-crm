<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Block\ProfileEdit;
use App\Module\User\Models\Data\User;
use App\Support\FileUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
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
     * @return View
     */
    public function index()
    {
        return view('user::profile', ['user' => Auth::user()]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function updateProfile(Request $request)
    {
        $userEditBlock = new ProfileEdit();
        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'email' => 'required|email',
                'contact_email' => 'email|nullable',
                'phone' => 'numeric|nullable',
                'contact_phone' => 'numeric|nullable',
                'birthday' => 'date:Y-m-d|nullable',
            ]);
            try {
                $userEditBlock->updateUser();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Profile has been updated!'));

            return  redirect()->route('user_profile');
        }
        return view('user::profile_edit', ['userEditBlock' => $userEditBlock]);
    }

    /**
     * @param Request $request
     * @param int $id
     * @return RedirectResponse|View
     */
    public function changeAvatar(Request $request, $id)
    {
        /* @var User $user */
        $user = Auth::user();
        if ($user->getId() != $id) return redirect()->route('user_profile')->withErrors('User ID mismatch');

        $request->validate([
            'avatar' => 'required|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $path = $request->file('avatar')->store('avatars');
        $fileUpload = new FileUpload();
        $fileUpload->deleteFromPublicUpload($user->getInfo()->getAvatar());
        $user->getInfo()->setAvatar($path)->save();
        $request->session()->flash('success', __('Avatar has been updated'));

        return redirect()->route('user_profile');
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
            $request->validate([
                'current_password' => 'required|min:3|max:255',
                'password' => 'required|min:3|max:255',
                'retype_password' => 'required|min:3|max:255|same:password',
            ]);
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
