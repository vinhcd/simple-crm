<?php

namespace App\Module\Manager\Models\Data;

use App\AbstractModel;
use App\Module\Manager\Api\Data\OrganizationInterface;

class Organization extends AbstractModel implements OrganizationInterface
{
    /**
     * @var string
     */
    protected $table = 'organization';
}
