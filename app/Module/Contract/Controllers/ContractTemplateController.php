<?php

namespace App\Module\Contract\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Contract\Api\ContractTemplateRepositoryInterface;
use App\Module\Contract\Block\ContractTemplateEdit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

class ContractTemplateController extends Controller
{
    /**
     * @var ContractTemplateRepositoryInterface
     */
    private $repository;

    /**
     * ContractController constructor.
     * @param ContractTemplateRepositoryInterface $repository
     */
    public function __construct(ContractTemplateRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $contractTemplates = $this->repository->getBuilder()->with('contract')->get();

        return view('contract::template_list', ['contractTemplates' => $contractTemplates]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $contractTemplate = $id ? $this->repository->getById($id) : $this->repository->create();

        $templateEditBlock = new ContractTemplateEdit($contractTemplate);

        if ($posts = $request->post()) {
            $request->validate([
                'contract_id' => 'required|integer',
                'name' => 'required|max:255',
                'content' => 'required',
            ]);
            try {
                $templateEditBlock->update();
            } catch (\Exception $e) {
                Log::error($e->getMessage());
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Template :template has been updated!', ['template' => $contractTemplate->getName()]));

            return redirect()->route('contract_template_create_update', ['id' => $contractTemplate->getId()]);
        }
        return view('contract::template_edit', ['templateEditBlock' => $templateEditBlock]);
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $template = $this->repository->getById($id);
        try {
            $this->repository->delete($template);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->back()->withErrors($e->getMessage());
        }
        session()->flash('success', __('Template :template has been removed!', ['template' => $template->getName()]));

        return redirect()->route('contract_template_list');
    }
}
