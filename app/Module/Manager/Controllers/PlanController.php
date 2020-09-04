<?php

namespace App\Module\Manager\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Manager\Api\PlanRepositoryInterface;

use App\Module\Manager\Block\PlanEdit;
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
    }

    /**
     * @return View
     */
    public function index()
    {
        $plans = $this->repository->getAll();

        return view('manager::plan_list', ['plans' => $plans]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function edit(Request $request, $id = '')
    {
        $plan = $id ? $this->repository->getById($id) : $this->repository->create();

        $planEditBlock = new PlanEdit($plan);
        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'monthly_price' => 'required|numeric|min:0',
                'max_staff' => 'required|integer|min:0',
                'trial_days' => 'required|integer|min:0',
            ]);
            try {
                $planEditBlock->update();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(__($e->getMessage()))->withInput();
            }
            $request->session()->flash('success', __('Plan :plan has been updated!', ['plan' => $plan->getName()]));

            return redirect()->route('manager_plan_list');
        }
        return view('manager::plan_edit', ['planEditBlock' => $planEditBlock]);
    }

    /**
     * @param integer $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $plan = $this->repository->getById($id);
        try {
            $this->repository->delete($plan);
        } catch (\Exception $e) {
            return redirect()->back()->withErrors(__($e->getMessage()));
        }
        session()->flash('success', __('Plan :plan has been removed!', ['plan' => $plan->getName()]));

        return redirect()->route('manager_plan_list');
    }
}
