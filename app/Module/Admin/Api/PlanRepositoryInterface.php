<?php

namespace App\Module\Admin\Api;

use App\Module\Admin\Api\Data\PlanInterface;
use Illuminate\Database\Eloquent\Collection;

interface PlanRepositoryInterface
{
    /**
     * @return PlanInterface
     */
    public function create();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param PlanInterface $plan
     * @return PlanInterface
     */
    public function save($plan);
}
