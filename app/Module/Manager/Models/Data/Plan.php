<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\PlanInterface;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method float getPrice()
 * @method $this setPrice(float $value)
 * @method integer getMaxStaff()
 * @method $this setMaxStaff(int $value)
 * @method integer getTrialDays()
 * @method $this setTrialDays(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Plan extends AbstractModel implements PlanInterface
{
    /**
     * @var string
     */
    protected $table = 'plan';

    /**
     * @var string[]
     */
    protected $properties = ['name', 'price', 'max_staff', 'trial_days', 'description'];
}
