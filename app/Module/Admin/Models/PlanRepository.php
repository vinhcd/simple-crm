<?php

namespace App\Module\Admin\Models;

use App\Module\Admin\Api\PlanRepositoryInterface;
use App\Module\Admin\Models\Data\Plan;

class PlanRepository implements PlanRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function create()
    {
        return new Plan();
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return Plan::all();
    }

    /**
     * @inheritDoc
     */
    public function save($plan)
    {
        return $plan->save();
    }
}
