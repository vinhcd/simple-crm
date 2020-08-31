<?php

namespace App\Module\User\Models;

use App\Module\User\Models\Data\UserGroup;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserGroupManagement
{
    /**
     * @param int $groupId
     * @param int[] $userIds
     * @throws \Exception
     */
    public function updateUsersForGroup($groupId, $userIds)
    {
        if (!Auth::user()->isSuperAdmin()) {
            $group = (new GroupRepository())->getById($groupId);
            if ($group->isSuperAdmin()) {
                throw new \Exception(__('You don\'t have permission to change Supper Admin user or group'));
            }
        }
        DB::beginTransaction();
        UserGroup::where('group_id', $groupId)->delete();
        foreach ($userIds as $userId) {
            $userGroup = new UserGroup();
            $userGroup->setGroupId($groupId);
            $userGroup->setUserId($userId);
            $userGroup->save();
        }
        DB::commit();
    }

    /**
     * @param int $userId
     * @param int[] $groupIds
     * @return void
     * @throws \Exception
     */
    public function updateGroupsForUser($userId, $groupIds)
    {
        if (!Auth::user()->isSuperAdmin()) {
            $user = (new UserRepository())->getById($userId);
            $groups = (new GroupRepository())->getByIds($groupIds);
            $isNewGroupAdmin = false;
            foreach ($groups as $group) {
                if ($group->isSuperAdmin()) {
                    $isNewGroupAdmin = true;
                    break;
                }
            }
            if ($user->isSuperAdmin() || $isNewGroupAdmin) throw new \Exception(__('You don\'t have permission to change Supper Admin user or group'));
        }
        DB::beginTransaction();
        UserGroup::where('user_id', $userId)->delete();
        foreach ($groupIds as $id) {
            $userGroup = new UserGroup();
            $userGroup->setGroupId($id);
            $userGroup->setUserId($userId);
            $userGroup->save();
        }
        DB::commit();
    }
}
