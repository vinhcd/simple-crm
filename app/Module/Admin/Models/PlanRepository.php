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
    public function getById($id)
    {
        return Plan::find($id);
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return Plan::all();
    }

    /**
     * @param Plan $plan
     * @return bool
     */
    public function save($plan)
    {
        return $plan->save();
    }

    /**
     * @param Plan $plan
     * @return bool|null
     * @throws \Exception
     */
    public function delete($plan)
    {
        return $plan->delete();
    }
}
