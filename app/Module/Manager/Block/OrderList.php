<?php

namespace App\Module\Manager\Block;

use App\Block\AbstractBlock;
use App\Module\Manager\Models\Data\PlanOrder;
use App\Module\Manager\Models\OrderRepository;

class OrderList extends AbstractBlock
{
    /**
     * @var OrderRepository
     */
    private $repository;

    /**
     * OrderList constructor.
     */
    public function __construct()
    {
        $this->repository = new OrderRepository();
    }

    /**
     * @return array
     */
    public function getOrdersData()
    {
        $ordersData = [];
        $orders = $this->repository->getBuilder()->with(['plan', 'organization'])->get();
        /* @var PlanOrder $order */
        foreach ($orders as $order) {
            $ordersData[$order->getId()]['id'] = $order->getId();
            $ordersData[$order->getId()]['plan'] = $order->plan->getName();
            $ordersData[$order->getId()]['organization'] = $order->organization->getName();
            $ordersData[$order->getId()]['start'] = $order->getStart();
            $ordersData[$order->getId()]['end'] = $order->getEnd();
            $ordersData[$order->getId()]['monthly_price'] = $order->getMonthlyPrice();
        }
        return $ordersData;
    }
}
