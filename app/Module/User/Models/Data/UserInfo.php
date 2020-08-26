<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method string getBirthday()
 * @method string getAddress()
 * @method $this setAddress(string $value)
 * @method string getSex()
 * @method $this setSex(string $value)
 * @method string getPersonalEmail()
 * @method $this setPersonalEmail(string $value)
 * @method string getPhone()
 * @method $this setPhone(string $value)
 * @method string getAvatar()
 * @method $this setAvatar(string $value)
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
    protected $properties = ['user_id', 'birthday', 'sex', 'personal_email', 'address', 'phone', 'avatar', 'description'];

    /**
     * @param $date
     * @return $this
     */
    public function setBirthday($date)
    {
        if (empty($date)) {
            $this->birthday = null;
        } else {
            $this->birthday = $date;
        }
        return $this;
    }
}
