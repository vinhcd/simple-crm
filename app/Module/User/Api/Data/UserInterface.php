<?php

namespace App\Module\User\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getEmail()
 * @method $this setEmail(string $value)
 * @method string getPassword()
 * @method $this setPassword(string $value)
 * @method string getFullName()
 * @method string getFirstName()
 * @method $this setFirstName(string $value)
 * @method string getLastName()
 * @method $this setLastName(string $value)
 */
interface UserInterface
{
    const RESOURCE_ID = 'user';

    /**
     * @return GroupInterface[] | Collection
     */
    public function getGroups();

    /**
     * @return DepartmentInterface[] | Collection
     */
    public function getDepartments();

    /**
     * @return bool
     */
    public function isSuperAdmin();
}
