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
     * @param integer $id
     * @return PlanInterface
     */
    public function getById($id);

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param PlanInterface $plan
     * @return bool
     */
    public function save($plan);

    /**
     * @param PlanInterface $plan
     * @return bool
     * @throws \Exception
     */
    public function delete($plan);
}
