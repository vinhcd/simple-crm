<?php

namespace App\Module\Admin\Models\Data;

use App\AbstractModel;
use App\Module\Admin\Api\Data\OrganizationInterface;

class Organization extends AbstractModel implements OrganizationInterface
{
    /**
     * @var string
     */
    protected $table = 'organization';
}
