<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;
use App\Module\Acl\Api\Data\RoleInterface;
use App\Module\Acl\Api\Data\RolePermissionInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method integer getActive()
 * @method $this setActive(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Role extends AbstractModel implements RoleInterface
{
    /**
     * @var string
     */
    protected $table = 'role';

    /**
     * automatically get/set properties
     *
     * @var string[]
     */
    protected $properties = ['name', 'active', 'description'];

    /**
     * @var int[]
     */
    protected $userIds = [];

    /**
     * @var int[]
     */
    protected $groupIds = [];

    /**
     * @var RolePermissionInterface[]
     */
    protected $permissions = [];

    /**
     * @return int[]
     */
    public function getUserIds()
    {
        if (!$this->userIds) {
            $roleUsers = $this->users()->get();
            /* @var RoleUser $roleUser */
            foreach ($roleUsers as $roleUser) {
                $this->userIds[] = $roleUser->getUserId();
            }
        }
        return $this->userIds;
    }

    /**
     * @return int[]
     */
    public function getGroupIds()
    {
        if (!$this->groupIds) {
            $roleGroups = $this->groups()->get();
            /* @var RoleGroup $roleGroup */
            foreach ($roleGroups as $roleGroup) {
                $this->groupIds[] = $roleGroup->getGroupId();
            }
        }
        return $this->groupIds;
    }

    /**
     * @return RolePermissionInterface[] | Collection
     */
    public function getPermissions()
    {
        if (!$this->permissions) {
            $this->permissions = $this->permissions()->get();
        }
        return $this->permissions;
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(RoleUser::class);
    }

    /**
     * @return HasMany
     */
    public function groups()
    {
        return $this->hasMany(RoleGroup::class);
    }

    /**
     * @return HasMany
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
