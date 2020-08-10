<?php

namespace App\Module\Manager\Models\Data;

use App\AbstractModel;
use App\Module\Manager\Api\Data\PlanInterface;

class Plan extends AbstractModel implements PlanInterface
{
    /**
     * @var string
     */
    protected $table = 'plan';
}
