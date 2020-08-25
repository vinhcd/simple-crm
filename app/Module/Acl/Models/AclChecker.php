<?php

namespace App\Module\Acl\Models;

use App\Module\Acl\Api\AclCheckerInterface;
use App\Module\Acl\Models\Data\RolePermission;
use App\Module\User\Models\Data\User;
use Illuminate\Database\Eloquent\Collection;

class AclChecker implements AclCheckerInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $resources = [];

    /**
     * @return $this
     */
    public function reset()
    {
        $this->user = null;
        $this->resources = [];

        return $this;
    }

    /**
     * @param User $user
     * @return $this
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @param string $resource
     * @param string $module
     * @return $this
     */
    public function addResource($resource, $module)
    {
        $this->resources[] = $module . '::' . $resource;

        return $this;
    }

    /**
     * @param string[] $resources
     * @param string $module
     * @return $this
     */
    public function setResources($resources, $module)
    {
        $this->resources = [];
        foreach ($resources as $resource) {
            $this->resources[] = $module . '::' . $resource;
        }
        return $this;
    }

    /**
     * @return bool
     */
    public function canRead()
    {
        if ($this->user->isSuperAdmin()) return true;

        if ($this->checkUserPermission()) return true;

        if ($this->checkGroupPermission()) return true;

        return false;
    }

    /**
     * @return bool|void
     */
    public function canWrite()
    {
        if ($this->user->isSuperAdmin()) return true;

        if ($this->checkUserPermission(RolePermission::WRITE)) return true;

        if ($this->checkGroupPermission(RolePermission::WRITE)) return true;

        return false;
    }

    /**
     * @param string $permissionCheck
     * @return bool
     */
    private function checkUserPermission($permissionCheck = RolePermission::READ)
    {
        /* @var RolePermission[]|Collection $rolePermissions */
        $rolePermissions = RolePermission::query()
            ->join('role', 'role_permission.role_id', '=', 'role.id')
            ->join('role_user', 'role_permission.role_id', '=', 'role_user.role_id')
            ->where('role.active', '=', 1)
            ->where('role_permission.permission', '=', $permissionCheck)
            ->where('role_user.user_id', '=', $this->user->getId())
            ->whereIn('role_permission.resource_id', $this->resources)
            ->get('resource_id');

        $allowedResources = [];
        foreach ($rolePermissions as $permission) {
            $allowedResources[] = $permission->getResourceId();
        }
        if (count(array_diff($this->resources, $allowedResources)) == 0) return true;

        return false;
    }

    /**
     * @param string $permissionCheck
     * @return bool
     */
    private function checkGroupPermission($permissionCheck = RolePermission::READ)
    {
        $groupIds = [];
        foreach ($this->user->getGroups() as $group) {
            $groupIds[] = $group->getId();
        }
        /* @var RolePermission[]|Collection $rolePermissions */
        $rolePermissions = RolePermission::query()
            ->join('role', 'role_permission.role_id', '=', 'role.id')
            ->join('role_group', 'role_permission.role_id', '=', 'role_group.role_id')
            ->where('role.active', '=', 1)
            ->where('role_permission.permission', '=', $permissionCheck)
            ->whereIn('role_group.group_id', $groupIds)
            ->whereIn('role_permission.resource_id', $this->resources)
            ->get('resource_id');

        $allowedResources = [];
        foreach ($rolePermissions as $permission) {
            $allowedResources[] = $permission->getResourceId();
        }
        if (count(array_diff($this->resources, $allowedResources)) == 0) return true;

        return false;
    }
}
