<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Module\Admin\Api\PlanRepositoryInterface;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PlanController extends Controller
{
    /**
     * @var PlanRepositoryInterface
     */
    protected $repository;

    /**
     * PlanController constructor.
     * @param PlanRepositoryInterface $repository
     */
    public function __construct(PlanRepositoryInterface $repository)
    {
        $this->repository = $repository;

        parent::__construct();
    }

    /**
     * @return View
     */
    public function index()
    {
        $plans = $this->repository->getAll();

        return view('admin.plan_list', ['plans' => $plans]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|View
     */
    public function create(Request $request)
    {
        if ($posts = $request->post()) {
            $plan = $this->repository->create();
            $plan->setName($posts['name']);
            $plan->setPrice($posts['price']);
            $plan->setMaxStaff($posts['max_staff']);
            $plan->setDaysOfTrial($posts['trial_days']);
            $this->repository->save($plan);

            return redirect()->route('admin_plan_list');
        }
        return view('admin.plan_create');
    }
}
