<?php

namespace App\Module\Manager\Models;

use App\Module\Manager\Api\PlanRepositoryInterface;
use App\Module\Manager\Models\Data\Plan;
use Illuminate\Database\Eloquent\Builder;

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
    public function getBuilder()
    {
        return Plan::query();
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
