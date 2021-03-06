<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method int getDepartmentId()
 * @method $this setDepartmentId(int $value)
 */
class UserDepartment extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'user_department';

    /**
     * @var array
     */
    protected $properties = ['user_id', 'department_id'];
}
