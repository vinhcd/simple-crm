<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;

/**
 * @method integer getId()
 * @method integer getRoleId()
 * @method $this setRoleId(int $value)
 * @method integer getUserId()
 * @method $this setUserId(int $value)
 */
class RoleUser extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'role_user';

    /**
     * automatically get/set properties
     *
     * @var string[]
     */
    protected $properties = ['role_id', 'user_id'];
}
