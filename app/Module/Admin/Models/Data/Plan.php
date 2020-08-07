<?php

namespace App\Module\Admin\Models\Data;

use App\AbstractModel;
use App\Module\Admin\Api\Data\PlanInterface;

class Plan extends AbstractModel implements PlanInterface
{
    /**
     * @var string
     */
    protected $table = 'plan';
}
