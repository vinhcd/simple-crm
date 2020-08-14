<?php

namespace App\Module\Acl\Api\Data;

/**
 * @method integer getId()
 * @method integer getRoleId()
 * @method $this setRoleId(int $value)
 * @method string getResourceId()
 * @method $this setResourceId(string $value)
 * @method string getPermission()
 * @method $this setPermission(string $value)
 */
interface RolePermissionInterface
{
    const READ = 'read';

    const WRITE = 'write';
}
