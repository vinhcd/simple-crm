<?php

namespace App\Module\User\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDisplayName()
 * @method $this setDisplayName(string $value)
 * @method integer getPriority()
 * @method $this setPriority(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
interface GroupInterface
{
    const RESOURCE_ID = 'group';

    const SUPER_ADMIN = 'superadmin';

    /**
     * @return UserInterface[] | Collection
     */
    public function getUsers();
}
