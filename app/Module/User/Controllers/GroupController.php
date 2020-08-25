<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\GroupRepositoryInterface;
use App\Module\User\Block\GroupEdit;
use App\Module\User\Models\Data\Group;
use App\Module\User\Models\Data\UserGroup;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * @var GroupRepositoryInterface
     */
    private $repository;

    /**
     * GroupController constructor.
     * @param GroupRepositoryInterface $repository
     */
    public function __construct(GroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function list()
    {
        $groups = $this->repository->getAll();

        return view('user::group_list', ['groups' => $groups]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $group = $id ? $this->repository->getById($id) : $this->repository->create();

        $groupEditBlock = new GroupEdit($group);

        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'display_name' => 'required|max:255',
            ]);
            if ($group->getName() == GroupInterface::SUPER_ADMIN) return redirect()->back()->withErrors(__('Super Admin group cannot be changed'));
            $groupEditBlock->update();
            if ($this->isDuplicate($group)) {
                return redirect()->back()->withErrors(__('Group is already exist'));
            }
            try {
                $this->repository->save($group);
            } catch (\Exception $e) {
                return redirect()->route('user_group_create_update', ['id' => $id])->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Group :group has been updated!', ['group' => $group->getDisplayName()]));

            return redirect()->route('user_group_create_update', ['id' => $group->getId()]);
        }
        return view('user::group_create', ['groupEditBlock' => $groupEditBlock]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateUsers(Request $request, $id = '')
    {
        if (!$id) {
            return redirect()->back()->withErrors(__('You must create group before adding users into it'));
        }
        $userIds = $request->post('users');
        $group = $this->repository->getById($id);
        try {
            DB::beginTransaction();
            UserGroup::where('group_id', $group->getId())->delete();
            if (is_array($userIds)) {
                foreach ($userIds as $userId) {
                    $userGroup = new UserGroup();
                    $userGroup->setGroupId($group->getId());
                    $userGroup->setUserId($userId);
                    $userGroup->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        session()->flash('success', __('Group :group has been updated!', ['group' => $group->getDisplayName()]));

        return redirect()->back();
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $group = $this->repository->getById($id);
        try {
            if ($group->getName() == GroupInterface::SUPER_ADMIN) throw new \Exception(__('Super Admin group cannot be removed'));
            $this->repository->delete($group);
        } catch (\Exception $e) {
            return redirect()->route('user_group_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('Group :group has been removed!', ['group' => $group->getDisplayName()]));

        return redirect()->route('user_group_list');
    }

    /**
     * @param GroupInterface $group
     * @return bool
     */
    private function isDuplicate($group)
    {
        /* @var Group $exist */
        $exist = $this->repository->getBuilder()->where('name', $group->getName())->get()->first();
        if ($exist && ($exist->getId() != $group->getId())) return true;

        return false;
    }
}
