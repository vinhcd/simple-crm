<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;
use App\Module\Acl\Api\Data\RolePermissionInterface;

/**
 * @method integer getId()
 * @method integer getRoleId()
 * @method $this setRoleId(int $value)
 * @method string getResourceId()
 * @method $this setResourceId(string $value)
 * @method string getPermission()
 * @method $this setPermission(string $value)
 */
class RolePermission extends AbstractModel implements RolePermissionInterface
{
    /**
     * @var string
     */
    protected $table = 'role_permission';

    /**
     * automatically get/set properties
     *
     * @var string[]
     */
    protected $properties = ['role_id', 'resource_id', 'permission'];
}
