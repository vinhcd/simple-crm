<?php

namespace App\Module\Manager\Api;

use App\Module\Manager\Api\Data\OrderInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface OrderRepositoryInterface
{
    /**
     * @return OrderInterface
     */
    public function create();

    /**
     * @param int $id
     * @return OrderInterface
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
     * @param OrderInterface $order
     * @return bool
     * @throws \Exception
     */
    public function save($order);

    /**
     * @param OrderInterface $order
     * @return bool
     * @throws \Exception
     */
    public function delete($order);
}
