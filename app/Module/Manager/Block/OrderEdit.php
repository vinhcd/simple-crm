<?php

namespace App\Module\Manager\Block;

use App\Block\AbstractBlock;
use App\Module\Manager\Models\Data\Organization;
use App\Module\Manager\Models\Data\Plan;
use App\Module\Manager\Models\Data\PlanOrder;
use App\Module\Manager\Models\OrderRepository;
use App\Module\Manager\Models\OrganizationRepository;
use App\Module\Manager\Models\PlanRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

class OrderEdit extends AbstractBlock
{
    /**
     * @var PlanOrder
     */
    private $order;

    /**
     * OrderEdit constructor.
     * @param PlanOrder $order
     */
    public function __construct(PlanOrder $order)
    {
        $this->order = $order;
    }

    /**
     * @return PlanOrder
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @return Plan[]|Collection
     */
    public function getPlans()
    {
        return (new PlanRepository())->getAll();
    }

    /**
     * @return Organization[]|Collection
     */
    public function getOrganizations()
    {
        return (new OrganizationRepository())->getAll();
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $order = $this->order;
        $order->setPlanId($posts['plan']);
        $order->setOrganizationId($posts['organization']);
        $order->setMonthlyPrice($posts['monthly_price']);
        $order->setStart($posts['start']);
        $order->setEnd($posts['end']);

        (new OrderRepository())->save($order);
    }
}
