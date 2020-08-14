<?php

namespace App\Module\Acl\Api\Data;

use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\UserInterface;

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
     * @return UserInterface[]
     */
    public function getUsers();

    /**
     * @return GroupInterface[]
     */
    public function getGroups();

    /**
     * @return RolePermissionInterface[]
     */
    public function getPermissions();
}
