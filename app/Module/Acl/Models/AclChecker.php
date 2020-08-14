<?php

namespace App\Module\Acl\Models;

use App\Module\Acl\Api\AclCheckerInterface;
use App\Module\Acl\Models\Data\RolePermission;
use App\Module\User\Models\Data\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Facades\DB;

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
     * @return $this
     */
    public function addResource($resource)
    {
        $this->resources[] = $resource;

        return $this;
    }

    /**
     * @param array $resources
     * @return $this
     */
    public function setResources($resources)
    {
        $this->resources = $resources;

        return $this;
    }

    /**
     * @return bool
     */
    public function canRead()
    {
        if ($this->user->isSuperAdmin()) return true;

        $groupIds = [];
        foreach ($this->user->getGroups() as $group) {
            $groupIds[] = $group->getId();
        }
        /* @var RolePermission[]|Collection $rolePermissions */
        $rolePermissions = RolePermission::query()
            ->join('role', 'role_permission.role_id', '=', 'role.id')
            ->join('role_item', 'role_permission.role_id', '=', 'role_item.role_id')
            ->where('role.active', '=', 1)
            ->whereIn('role_permission.resource_id', $this->resources)
            ->where(function ($query) use ($groupIds) {
                /* @var Builder $query */
                $query->where(function ($subQuery) use ($groupIds) {
                    /* @var Builder $subQuery */
                    $subQuery->whereNotNull('role_item.user_id')
                        ->where('role_item.user_id', '=', $this->user->getId());
                })
                ->orWhere(function ($subQuery) use ($groupIds) {
                    /* @var Builder $subQuery */
                    $subQuery->whereNotNull('role_item.group_id')
                        ->whereIn('role_item.group_id', $groupIds);
                });
            })
            ->get();

        $allowedResources = [];
        foreach ($rolePermissions as $permission) {
            $allowedResources[] = $permission->getResourceId();
        }
        if (count(array_diff($this->resources, $allowedResources)) == 0) return true;

        return false;
    }

    /**
     * @return bool|void
     */
    public function canWrite()
    {
        if ($this->user->isSuperAdmin()) return true;

        $groupIds = [];
        foreach ($this->user->getGroups() as $group) {
            $groupIds[] = $group->getId();
        }
        /* @var RolePermission[] $rolePermissions */
        $rolePermissions = DB::table('role_permission')
            ->join('role', 'role_permission.role_id', '=', 'role.id')
            ->join('role_item', 'role_permission.role_id', '=', 'role_item.role_id')
            ->where('role.active', '=', 1)
            ->where('role_permission.resource_id', 'in', implode(',', $this->resources))
            ->where('role_permission.permission', '=', RolePermission::WRITE)
            ->where(function ($query) use ($groupIds) {
                /* @var Builder $query */
                $query->where('role_item.user_id', '=', $this->user->getId())
                    ->orWhere('role_item.group_id', 'in', implode(',', $groupIds));
            })
            ->get();

        $allowedResources = [];
        foreach ($rolePermissions as $permission) {
            $allowedResources[] = $permission->getResourceId();
        }
        if (count(array_diff($this->resources, $allowedResources)) == 0) return true;

        return false;
    }
}
