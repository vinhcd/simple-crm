<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Module\Admin\Models\OrganizationRepository;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrganizationController extends Controller
{
    /**
     * @var OrganizationRepository
     */
    protected $repository;

    /**
     * OrganizationController constructor.
     */
    public function __construct()
    {
        $this->repository = new OrganizationRepository();
    }

    /**
     * @return View
     */
    public function index()
    {
        $organizations = $this->repository->getAll();

        return view('admin.organization_list', ['organizations' => $organizations]);
    }

    /**
     * @return View
     */
    public function create(Request $request)
    {

    }
}
