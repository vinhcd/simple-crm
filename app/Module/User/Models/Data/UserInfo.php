<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;

/**
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method string getUuid()
 * @method $this setUuid(string $value)
 * @method string getBirthday()
 * @method string getJoinDate()
 * @method string getAddress1()
 * @method $this setAddress1(string $value)
 * @method string getAddress2()
 * @method $this setAddress2(string $value)
 * @method string getSex()
 * @method $this setSex(string $value)
 * @method string getPersonalEmail()
 * @method $this setPersonalEmail(string $value)
 * @method string getPhone()
 * @method $this setPhone(string $value)
 * @method string getContactPhone()
 * @method $this setContactPhone(string $value)
 * @method string getContactEmail()
 * @method $this setContactEmail(string $value)
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
    protected $properties = [
        'user_id',
        'uuid',
        'birthday',
        'sex',
        'join_date',
        'personal_email',
        'address1',
        'address2',
        'phone',
        'avatar',
        'contact_phone',
        'contact_email',
        'description'
    ];

    /**
     * @param string $date
     * @return $this
     */
    public function setBirthday($date)
    {
        $this->birthday = !empty($date) ? $date : null;

        return $this;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setJoinDate($date)
    {
        $this->join_date = !empty($date) ? $date : null;

        return $this;
    }
}
