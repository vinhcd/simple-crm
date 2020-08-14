<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;

/**
 * @method integer getId()
 * @method integer getRoleId()
 * @method $this setRoleId(int $value)
 * @method integer getGroupId()
 * @method $this setGroupId(int $value)
 */
class RoleGroup extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'role_group';

    /**
     * automatically get/set properties
     *
     * @var string[]
     */
    protected $properties = ['role_id', 'group_id'];
}
