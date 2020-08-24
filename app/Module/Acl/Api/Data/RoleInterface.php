<?php

namespace App\Module\Acl\Api\Data;

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
     * @return int[]
     */
    public function getUserIds();

    /**
     * @return int[]
     */
    public function getGroupIds();

    /**
     * @return RolePermissionInterface[]
     */
    public function getPermissions();
}
