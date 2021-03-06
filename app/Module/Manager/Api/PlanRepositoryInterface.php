<?php

namespace App\Module\Manager\Api;

use App\Module\Manager\Api\Data\PlanInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PlanRepositoryInterface
{
    /**
     * @return PlanInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return PlanInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param PlanInterface $plan
     * @return bool
     * @throws \Exception
     */
    public function save($plan);

    /**
     * @param PlanInterface $plan
     * @return bool
     * @throws \Exception
     */
    public function delete($plan);
}
