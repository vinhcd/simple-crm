<?php

namespace App\Module\Manager\Controllers;

use App\Module\Manager\Api\OrderRepositoryInterface;
use App\Module\Manager\Block\OrderEdit;
use App\Module\Manager\Block\OrderList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class OrderController
{
    /**
     * @var OrderRepositoryInterface
     */
    private $repository;

    /**
     * OrderController constructor.
     * @param OrderRepositoryInterface $repository
     */
    public function __construct(OrderRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        return view('manager::order_list', ['ordersListBlock' => new OrderList()]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function edit(Request $request, $id = '')
    {
        $order = $id ? $this->repository->getById($id) : $this->repository->create();

        $orderEditBlock = new OrderEdit($order);

        if ($posts = $request->post()) {
            $request->validate([
                'organization' => 'required|integer',
                'plan' => 'required|integer',
                'start' => 'required|date:Y-m-d',
                'end' => 'required|date:Y-m-d',
                'monthly_price' => 'required|numeric|min:0',
            ]);
            try {
                $orderEditBlock->update();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors($e->getMessage())->withInput();
            }
            $request->session()->flash(
                'success',
                __('Order :order has been updated!', ['order' => $orderEditBlock->getOrder()->getId()])
            );
            return redirect()->route('manager_order_edit', ['id' => $order->getId()]);
        }
        return view('manager::order_edit', ['orderEditBlock' => $orderEditBlock]);
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $order = $this->repository->getById($id);
        try {
            $this->repository->delete($order);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
        session()->flash('success', __('Order :order has been removed!', ['order' => $order->getId()]));

        return redirect()->route('manager_order_list');
    }
}
