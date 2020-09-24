<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\OrganizationInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Date;

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
     * @var Plan
     */
    protected $plan;

    /**
     * @var Collection
     */
    protected $orders;

    /**
     * @return Plan | null
     */
    public function getPlan()
    {
        if (!$this->plan) {
            $this->plan = $this->plans()
                ->where('end', '>=', Date::now()->toDateString())
                ->get()->last();
        }
        return $this->plan;
    }

    /**
     * @return Collection
     */
    public function getOrders()
    {
        if (!$this->orders) {
            $this->orders = $this->orders()->get();
        }
        return $this->orders;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setRegisterDate($date)
    {
        $this->register_date = !empty($date) ? $date : null;

        return $this;
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(PlanOrder::class, 'plan_order');
    }

    /**
     * @return BelongsToMany
     */
    public function plans()
    {
        return $this->belongsToMany(Plan::class, 'plan_order');
    }
}
