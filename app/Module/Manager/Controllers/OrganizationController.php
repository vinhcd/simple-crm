<?php

namespace App\Module\Manager\Controllers;

use App\Module\Manager\Api\OrganizationRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\View\View;

class OrganizationController
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
        if ($id) {
            $org = $this->repository->getById($id);
        } else {
            $org = $this->repository->create();
        }
        if ($posts = $request->post()) {
            $org->name = $posts['name'];
            $org->phone_number = $posts['phone_number'];
            $org->tax_number = $posts['tax_number'];
            $org->address = $posts['address'];
            $org->register_date = Date::createFromFormat('Y-m-d', $posts['register_date'])->toDateString();
            $org->plan_id = $posts['plan_id'];
            $org->comment = $posts['comment'];

            $this->repository->save($org);

            return redirect()->route('manager_organization_list');
        }
        return view('manager::organization_create', ['org' => $org]);
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
