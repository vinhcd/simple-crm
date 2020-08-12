<?php

namespace App\Module\Acl\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @property integer id
 * @property string name
 * @property integer active
 * @property string description
 */
interface RoleInterface
{
    /**
     * @return Collection of RoleItemInterface
     */
    public function getItems();

    /**
     * @return Collection of RolePermissionInterface
     */
    public function getPermissions();
}
