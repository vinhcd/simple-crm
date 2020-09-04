<?php

namespace App\Module\Manager\Models\Data;

use App\Models\AbstractModel;
use App\Module\Manager\Api\Data\OrderInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
class PlanOrder extends AbstractModel implements OrderInterface
{
    /**
     * @var string
     */
    protected $table = 'plan_order';

    /**
     * @var string[]
     */
    protected $properties = ['organization_id', 'plan_id', 'start', 'end', 'monthly_price'];

    /**
     * @return BelongsTo
     */
    public function plan()
    {
        return $this->belongsTo(Plan::class);
    }

    /**
     * @return BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }
}
