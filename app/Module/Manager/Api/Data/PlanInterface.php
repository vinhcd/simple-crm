<?php

namespace App\Module\Manager\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method float getMonthlyPrice()
 * @method $this setMonthlyPrice(float $value)
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

    /**
     * @return OrderInterface[]|Collection
     */
    public function getOrders();
}
