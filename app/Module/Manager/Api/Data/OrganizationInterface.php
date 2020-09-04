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
 * @method string getEmail()
 * @method $this setEmail(string $value)
 * @method $this setDomain(string $value)
 * @method string getPhoneNumber()
 * @method $this setPhoneNumber(string $value)
 * @method string getTaxNumber()
 * @method $this setTaxNumber(string $value)
 * @method string getAddress()
 * @method $this setAddress(string $value)
 * @method string getRegisterDate()
 * @method $this setRegisterDate(string $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
interface OrganizationInterface
{
    const RESOURCE_ID = 'organization';

    /**
     * @return PlanInterface|null
     */
    public function getPlan();

    /**
     * @return OrderInterface[]|Collection
     */
    public function getOrders();
}
