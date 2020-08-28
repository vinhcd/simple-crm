<?php

namespace App\Module\Manager\Models\Data;

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
 */
class OrganizationPlan
{
    /**
     * @var string
     */
    protected $table = 'organization_plan';

    /**
     * @var string[]
     */
    protected $properties = ['organization_id', 'plan_id', 'start', 'end'];
}
