<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\OrganizationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getUuid()
 * @method $this setUuid(string $value)
 * @method string getDomain()
 * @method $this setDomain(string $value)
 * @method string getEmail()
 * @method $this setEmail(string $value)
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
class Organization extends AbstractModel implements OrganizationInterface
{
    /**
     * @var string
     */
    protected $table = 'organization';

    /**
     * @var string[]
     */
    protected $properties = ['name', 'uuid', 'domain', 'email', 'phone_number', 'register_date', 'tax_number', 'address', 'description'];

    /**
     * @var Collection
     */
    protected $plans;

    /**
     * @return Plan | null
     */
    public function getPlan()
    {
        return $this->getPlanHistory()->last();
    }

    /**
     * @return Collection
     */
    public function getPlanHistory()
    {
        if (!$this->plans) {
            $this->plans = $this->plans()->get();
        }
        return $this->plans;
    }

    /**
     * @return BelongsToMany
     */
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'organization_plan');
    }
}
