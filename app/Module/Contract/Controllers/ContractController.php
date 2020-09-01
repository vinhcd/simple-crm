<?php

namespace App\Module\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Contract\Api\ContractRepositoryInterface;
use App\Module\Contract\Block\ContractEdit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContractController extends Controller
{
    /**
     * @var ContractRepositoryInterface
     */
    private $repository;

    /**
     * ContractController constructor.
     * @param ContractRepositoryInterface $repository
     */
    public function __construct(ContractRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $contracts = $this->repository->getAll();

        return view('contract::contract_list', ['contracts' => $contracts]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $contract = $id ? $this->repository->getById($id) : $this->repository->create();

        $contractEditBlock = new ContractEdit($contract);

        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
            ]);
            try {
                $contractEditBlock->update();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Contract :contract has been updated!', ['contract' => $contract->getName()]));

            return redirect()->route('contract_create_update', ['id' => $contract->getId()]);
        }
        return view('contract::contract_edit', ['contractEditBlock' => $contractEditBlock]);
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $contract = $this->repository->getById($id);
        try {
            $this->repository->delete($contract);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
        session()->flash('success', __('Contract :contract has been removed!', ['contract' => $contract->getName()]));

        return redirect()->route('contract_list');
    }
}
