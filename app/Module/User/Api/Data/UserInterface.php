<?php

namespace App\Module\User\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method string setName(string $value)
 * @method string getEmail()
 * @method string setEmail(string $value)
 * @method string getPassword()
 * @method string setPassword(string $value)
 * @method string getFirstName()
 * @method string setFirstName(string $value)
 * @method string getLastName()
 * @method string setLastName(string $value)
 * @method string getDescription()
 * @method string setDescription(string $value)
 */
interface UserInterface
{
    const RESOURCE_ID = 'user';

    /**
     * @return GroupInterface[] | Collection
     */
    public function getGroups();

    /**
     * @return bool
     */
    public function isSuperAdmin();
}
