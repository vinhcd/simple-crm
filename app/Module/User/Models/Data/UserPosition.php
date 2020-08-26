<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method int getPositionId()
 * @method $this setPositionId(int $value)
 */
class UserPosition extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'user_position';

    /**
     * @var array
     */
    protected $properties = ['user_id', 'position_id'];
}
