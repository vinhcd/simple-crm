<?php

namespace App\Module\Acl\Models\Data;

use App\AbstractModel;
use App\Module\Acl\Api\Data\RoleInterface;
use Illuminate\Database\Eloquent\Collection;

class Role extends AbstractModel implements RoleInterface
{
    /**
     * @var string
     */
    protected $table = 'role';

    /**
     * @return Collection
     */
    public function getItems()
    {
        return $this->hasMany(RoleItem::class)->get();
    }

    /**
     * @return Collection
     */
    public function getPermissions()
    {
        return $this->hasMany(RolePermission::class)->get();
    }
}
