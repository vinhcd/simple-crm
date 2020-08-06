<?php

namespace App\Module\Admin\Models;

use App\Module\Admin\Api\OrganizationRepositoryInterface;
use App\Module\Admin\Models\Data\Organization;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    public function create()
    {
        return new Organization();
    }

    /**
     * @return Organization[]
     */
    public function getAll()
    {
        return Organization::all();
    }

    public function save($organization)
    {
        // TODO: Implement save() method.
    }
}
