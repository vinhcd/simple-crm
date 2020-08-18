<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method string getBirthday()
 * @method $this setBirthday(string $value)
 * @method string getAddress()
 * @method $this setAddress(string $value)
 * @method string getPhone()
 * @method $this setPhone(string $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class UserInfo extends AbstractModel
{
    /**
     * @var string
     */
    protected $table = 'user_info';

    /**
     * @var array
     */
    protected $properties = ['user_id', 'birthday', 'address', 'phone', 'description'];
}
