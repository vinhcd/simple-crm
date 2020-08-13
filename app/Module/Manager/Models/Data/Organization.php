<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\OrganizationInterface;

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
class Organization extends AbstractModel implements OrganizationInterface
{
    /**
     * @var string
     */
    protected $table = 'organization';

    /**
     * @var string[]
     */
    protected $properties = ['name', 'uuid', 'domain', 'phone_number', 'tax_number', 'address', 'description'];

    public function getPlan()
    {
        // TODO: Implement getPlan() method.
    }

    public function getPlanHistory()
    {
        // TODO: Implement getPlanHistory() method.
    }

    public function setPlan($plan)
    {
        // TODO: Implement setPlan() method.
    }
}
