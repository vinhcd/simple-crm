<?php

namespace App\Module\Manager\Api\Data;

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
interface PlanInterface
{
    const RESOURCE_ID = 'plan';
}
