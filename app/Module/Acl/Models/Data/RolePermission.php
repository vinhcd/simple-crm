<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;
use App\Module\Acl\Api\Data\RolePermissionInterface;

class RolePermission extends AbstractModel implements RolePermissionInterface
{
    /**
     * @var string
     */
    protected $table = 'role_permission';
}
