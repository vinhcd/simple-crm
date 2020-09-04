<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\PlanInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
class Plan extends AbstractModel implements PlanInterface
{
    /**
     * @var string
     */
    protected $table = 'plan';

    /**
     * @var string[]
     */
    protected $properties = ['name', 'monthly_price', 'max_staff', 'trial_days', 'description'];

    /**
     * @var PlanOrder[]|Collection
     */
    protected $orders;

    /**
     * @return PlanOrder[]|Collection
     */
    public function getOrders()
    {
        if (!$this->orders) {
            $this->orders = $this->orders()->get();
        }
        return $this->orders;
    }

    /**
     * @return HasMany
     */
    public function orders()
    {
        return $this->hasMany(PlanOrder::class, 'plan_order');
    }
}
