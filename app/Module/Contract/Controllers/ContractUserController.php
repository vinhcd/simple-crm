<?php

namespace App\Module\Contract\Controllers;

use App\Module\Contract\Api\ContractUserRepositoryInterface;
use App\Module\Contract\Block\ContractTemplateEdit;
use App\Module\Contract\Block\ContractUserEdit;
use App\Module\Contract\Block\ContractUserList;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContractUserController
{
    /**
     * @var ContractUserRepositoryInterface
     */
    private $repository;

    /**
     * UserContractController constructor.
     * @param ContractUserRepositoryInterface $repository
     */
    public function __construct(ContractUserRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $userListBlock = new ContractUserList();

        return view('contract::user_list', ['userListBlock' => $userListBlock]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $contractUser = $id ? $this->repository->getById($id) : $this->repository->create();

        $contractUserEditBlock = new ContractUserEdit($contractUser);

        if ($posts = $request->post()) {
            $request->validate([
                'contract_id' => 'required|integer',
                'user_id' => 'required|integer',
                'template_id' => 'required|integer',
                'start' => 'required|date:Y-m-d',
                'end' => 'required|date:Y-m-d',
            ]);
            try {
                $contractUserEditBlock->update();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash(
                'success',
                __('Contract for :contractUser has been updated!', ['contractUser' => $contractUserEditBlock->getUser()->getName()])
            );
            return redirect()->route('contract_user_create_update', ['id' => $contractUser->getId()]);
        }
        return view('contract::user_edit', ['contractUserEditBlock' => $contractUserEditBlock]);
    }
}
