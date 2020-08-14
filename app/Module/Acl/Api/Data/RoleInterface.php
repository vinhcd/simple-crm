<?php

namespace App\Module\Acl\Api\Data;

use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\UserInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method integer getActive()
 * @method $this setActive(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
interface RoleInterface
{
    /**
     * @return UserInterface[] | Collection
     */
    public function getUsers();

    /**
     * @param UserInterface $user
     * @return $this
     */
    public function addUsers($user);

    /**
     * @param UserInterface[] $users
     * @return $this
     */
    public function setUsers($users);

    /**
     * @return GroupInterface[] | Collection
     */
    public function getGroups();

    /**
     * @param GroupInterface $group
     * @return $this
     */
    public function addGroup($group);

    /**
     * @param GroupInterface[] $groups
     * @return $this
     */
    public function setGroups($groups);

    /**
     * @return RolePermissionInterface[] | Collection
     */
    public function getPermissions();

    /**
     * @param RolePermissionInterface $permission
     * @return $this
     */
    public function addPermission($permission);

    /**
     * @param RolePermissionInterface[] $permissions
     * @return $this
     */
    public function setPermissions($permissions);
}
