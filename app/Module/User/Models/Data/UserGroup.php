<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method int getGroupId()
 * @method $this setGroupId(int $value)
 */
class UserGroup extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'user_group';

    /**
     * @var string[]
     */
    protected $properties = ['user_id', 'group_id'];
}
