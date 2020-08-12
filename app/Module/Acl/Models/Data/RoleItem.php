<?php

namespace App\Module\Acl\Models\Data;

use App\AbstractModel;
use App\Module\Acl\Api\Data\RoleItemInterface;

class RoleItem extends AbstractModel implements RoleItemInterface
{
    /**
     * @var string
     */
    protected $table = 'role_item';
}
