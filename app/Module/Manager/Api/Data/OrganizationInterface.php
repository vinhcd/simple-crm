<?php

namespace App\Module\Manager\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getUuid()
 * @method $this setUuid(string $value)
 * @method string getDomain()
 * @method $this setDomain(string $value)
 * @method string getPhoneNumber()
 * @method $this setPhoneNumber(string $value)
 * @method string getTaxNumber()
 * @method $this setTaxNumber(string $value)
 * @method string getAddress()
 * @method $this setAddress(string $value)
 * @method string getRegisterDate()
 * @method $this setRegisterDate(string $value)
 * @method string getComment()
 * @method $this setComment(string $value)
 */
interface OrganizationInterface
{
    const RESOURCE_ID = 'organization';

    /**
     * @return PlanInterface|null
     */
    public function getPlan();

    /**
     * @return Collection of PlanInterface
     */
    public function getPlanHistory();

    /**
     * @param PlanInterface $plan
     * @return $this
     */
    public function setPlan($plan);
}
