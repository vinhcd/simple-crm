<?php

namespace App\Module\Admin\Models\Data;

use App\AbstractModel;
use App\Module\Admin\Api\Data\PlanInterface;

class Plan extends AbstractModel implements PlanInterface
{
    /**
     * @var string
     */
    protected $table = 'plan';

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @inheritDoc
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getMaxStaff()
    {
        return $this->max_staff;
    }

    /**
     * @inheritDoc
     */
    public function setMaxStaff($maxStaff)
    {
        $this->max_staff = $maxStaff;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function getDaysOfTrial()
    {
        return $this->days_of_trial;
    }

    /**
     * @inheritDoc
     */
    public function setDaysOfTrial($trialDays)
    {
        $this->days_of_trial = $trialDays;

        return $this;
    }
}
