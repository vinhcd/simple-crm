<?php

namespace App\Module\User\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDisplayName()
 * @method $this setDisplayName(string $value)
 * @method int getParentId()
 * @method $this setParentId(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
interface DepartmentInterface
{
    const RESOURCE_ID = 'department';

    /**
     * @return UserInterface[] | Collection
     */
    public function getUsers();
}
