<?php

namespace App\Module\Manager\Models;

use App\Module\Manager\Api\OrderRepositoryInterface;
use App\Module\Manager\Models\Data\PlanOrder;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class OrderRepository implements OrderRepositoryInterface
{
    /**
     * @return PlanOrder
     */
    public function create()
    {
        return new PlanOrder();
    }

    /**
     * @param int $id
     * @return PlanOrder
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return PlanOrder::findOrFail($id);
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return PlanOrder::query();
    }

    /**
     * @return PlanOrder[]|Collection
     */
    public function getAll()
    {
        return PlanOrder::all();
    }

    /**
     * @param PlanOrder $order
     * @return bool
     * @throws \Exception
     */
    public function save($order)
    {
        return $order->save();
    }

    /**
     * @param PlanOrder $order
     * @return bool
     * @throws \Exception
     */
    public function delete($order)
    {
        return $order->delete();
    }
}
