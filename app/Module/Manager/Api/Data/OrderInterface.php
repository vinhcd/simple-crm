<?php

namespace App\Module\Manager\Api\Data;

/**
 * @method int getId()
 * @method int getOrganizationId()
 * @method $this setOrganizationId(int $value)
 * @method int getPlanId()
 * @method $this setPlanId(int $value)
 * @method string getStart()
 * @method $this setStart(string $value)
 * @method string getEnd()
 * @method $this setEnd(string $value)
 * @method float getMonthlyPrice()
 * @method $this setMonthlyPrice(float $value)
 */
interface OrderInterface
{
    const RESOURCE_ID = 'plan_order';
}
