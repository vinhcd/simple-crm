<?php

namespace App\Module\Acl\Block;

use App\Block\AbstractBlock;
use App\Module\Acl\Models\Data\Role;
use App\Module\Acl\Models\Data\RoleGroup;
use App\Module\Acl\Models\Data\RolePermission;
use App\Module\Acl\Models\Data\RoleUser;
use App\Module\Acl\Models\RoleRepository;
use App\Module\Acl\Support\ResourceConfig;
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
        $this->updatePermissions();
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
        foreach ($groups as $group) {
            $groupsData[$group->getId()]['id'] = $group->getId();
            $groupsData[$group->getId()]['name'] = $group->getDisplayName();
            $groupsData[$group->getId()]['in_role'] = in_array($group->getId(), $this->getRole()->getGroupIds()) ? true : false;
        }
        return $groupsData;
    }

    /**
     * @return array
     */
    public function getPermissionsData()
    {
        $permissionsData = [];
        $role = $this->getRole();
        $resInRole = [];
        foreach ($role->getPermissions() as $permission) {
            $resInRole[] = $permission->getResourceId() . '::' . $permission->getPermission();
        }
        $allRes = ResourceConfig::getAll();
        foreach ($allRes as $res) {
            $permissionsData[$res]['name'] = $res;
            $permissionsData[$res]['in_role'] = in_array($res, $resInRole) ? true : false;
        }
        return $permissionsData;
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
        $role->setActive($posts['active']);
        $role->setDescription($posts['description'] ?: '');

        $roleRepository->save($role);
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function updatePermissions()
    {
        $posts = Request::post();

        $role = $this->getRole();
        RolePermission::where('role_id', $role->getId())->delete();
        if (isset($posts['permissions'])) {
            foreach ($posts['permissions'] as $permissionChain) {
                list($module, $resource, $permission) = explode('::', $permissionChain);
                $rolePermission = new RolePermission();
                $rolePermission->setRoleId($role->getId());
                $rolePermission->setResourceId($module . '::' . $resource);
                $rolePermission->setPermission($permission);
                $rolePermission->save();
            }
        }
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
            RoleUser::where('role_id', $role->getId())->delete();
            foreach ($posts['users'] as $userId) {
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
            RoleGroup::where('role_id', $role->getId())->delete();
            foreach ($posts['groups'] as $groupId) {
                $roleGroup = new RoleGroup();
                $roleGroup->setRoleId($role->getId());
                $roleGroup->setGroupId($groupId);
                $roleGroup->save();
            }
        }
    }
}
