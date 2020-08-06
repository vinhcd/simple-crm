<?php

namespace App\Module\Admin\Models;

use App\Module\Admin\Models\Data\Organization;

class OrganizationRepository
{
    /**
     * @return Organization[]
     */
    public function getAll()
    {
        return Organization::all();
    }
}
