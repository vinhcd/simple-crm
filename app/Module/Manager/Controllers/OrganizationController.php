<?php

namespace App\Module\Manager\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Manager\Api\OrganizationRepositoryInterface;

use App\Module\Manager\Block\OrganizationEdit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * @var OrganizationRepositoryInterface
     */
    protected $repository;

    /**
     * OrganizationController constructor.
     * @param OrganizationRepositoryInterface $repository
     */
    public function __construct(OrganizationRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $organizations = $this->repository->getAll();

        return view('manager::organization_list', ['organizations' => $organizations]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     * @throws \Exception
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $org = $id ? $this->repository->getById($id) : $this->repository->create();

        $orgEditBlock = new OrganizationEdit($org);
        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'domain' => 'required|max:255',
                'email' => 'required|max:255',
                'register_date' => 'required|date:Y-m-d',
                'phone_number' => 'required|numeric',
            ]);
            try {
                $orgEditBlock->update();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors(__($e->getMessage()));
            }

            return redirect()->route('manager_organization_list');
        }
        return view('manager::organization_create', ['orgEditBlock' => $orgEditBlock]);
    }

    /**
     * @param integer $id
     * @return RedirectResponse
     * @throws \Exception
     */
    public function delete($id)
    {
        $this->repository->delete($this->repository->getById($id));

        return redirect()->route('manager_organization_create_update');
    }
}
