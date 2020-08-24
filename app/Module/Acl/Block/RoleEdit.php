<?php

namespace App\Module\Acl\Block;

use App\Block\AbstractBlock;
use App\Module\Acl\Models\Data\Role;
use App\Module\Acl\Models\Data\RoleGroup;
use App\Module\Acl\Models\Data\RoleUser;
use App\Module\Acl\Models\RoleRepository;
use App\Module\User\Api\GroupRepositoryInterface;
use App\Module\User\Api\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class RoleEdit extends AbstractBlock
{
    /**
     * @var Role
     */
    private $role;

    /**
     * AclEdit constructor.
     * @param Role $role
     */
    public function __construct($role)
    {
        $this->role = $role;
    }

    /**
     * @return Role
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        DB::beginTransaction();
        $this->updateRoleInfo();
        $this->updateRoleUsers();
        $this->updateRoleGroups();
        DB::commit();
    }

    /**
     * @return array
     */
    public function getUsersData()
    {
        $usersData = [];
        /* @var UserRepositoryInterface $userRepository */
        $userRepository = app(UserRepositoryInterface::class);

        $users = $userRepository->getAll();
        foreach ($users as $user) {
            $usersData[$user->getId()]['id'] = $user->getId();
            $usersData[$user->getId()]['name'] = $user->getFullName() ? $user->getFullName() : $user->getName();
            $usersData[$user->getId()]['in_role'] = in_array($user->getId(), $this->getRole()->getUserIds()) ? true : false;
        }
        return $usersData;
    }

    /**
     * @return array
     */
    public function getGroupsData()
    {
        $groupsData = [];
        /* @var GroupRepositoryInterface $groupRepository */
        $groupRepository = app(GroupRepositoryInterface::class);

        $groups = $groupRepository->getAll();
        \StaticLogger::log($this->getRole()->getGroupIds());
        foreach ($groups as $group) {
            $groupsData[$group->getId()]['id'] = $group->getId();
            $groupsData[$group->getId()]['name'] = $group->getDisplayName();
            $groupsData[$group->getId()]['in_role'] = in_array($group->getId(), $this->getRole()->getGroupIds()) ? true : false;
        }
        return $groupsData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateRoleInfo()
    {
        $posts = Request::post();

        $roleRepository = new RoleRepository();
        $role = $this->getRole();
        $role->setName($posts['name']);
        if ($posts['active']) $role->setActive($posts['active']);
        if ($posts['description']) $role->setDescription($posts['description']);

        $roleRepository->save($role);
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateRoleUsers()
    {
        $posts = Request::post();

        $role = $this->getRole();
        if (isset($posts['users'])) {
            $userIds = $posts['users'];
            RoleUser::where('role_id', $role->getId())->delete();
            foreach ($userIds as $userId) {
                $roleUser = new RoleUser();
                $roleUser->setRoleId($role->getId());
                $roleUser->setUserId($userId);
                $roleUser->save();
            }
        }
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateRoleGroups()
    {
        $posts = Request::post();

        $role = $this->getRole();
        if (isset($posts['groups'])) {
            $groupIds = $posts['groups'];
            RoleGroup::where('role_id', $role->getId())->delete();
            foreach ($groupIds as $groupId) {
                $roleGroup = new RoleGroup();
                $roleGroup->setRoleId($role->getId());
                $roleGroup->setGroupId($groupId);
                $roleGroup->save();
            }
        }
    }
}
