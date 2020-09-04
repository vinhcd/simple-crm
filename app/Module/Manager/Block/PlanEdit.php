<?php

namespace App\Module\Manager\Block;

use App\Block\AbstractBlock;
use App\Module\Manager\Models\Data\Plan;
use App\Module\Manager\Models\PlanRepository;
use Illuminate\Support\Facades\Request;

class PlanEdit extends AbstractBlock
{
    /**
     * @var Plan
     */
    private $plan;

    /**
     * PlanEdit constructor.
     * @param Plan $plan
     */
    public function __construct(Plan $plan)
    {
        $this->plan = $plan;
    }

    /**
     * @return Plan
     */
    public function getPlan()
    {
        return $this->plan;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $plan = $this->plan;
        $plan->setName($posts['name']);
        $plan->setMonthlyPrice($posts['monthly_price']);
        $plan->setMaxStaff($posts['max_staff']);
        $plan->setTrialDays($posts['trial_days']);
        $plan->setDescription($posts['description'] ?: '');

        $repo = new PlanRepository();
        $repo->save($plan);
    }
}
