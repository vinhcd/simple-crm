<?php

namespace App\Module\Acl\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Acl\Api\RoleRepositoryInterface;
use Illuminate\View\View;

class AclController extends Controller
{
    /**
     * @var RoleRepositoryInterface
     */
    private $repository;

    /**
     * AclController constructor.
     * @param RoleRepositoryInterface $repository
     */
    public function __construct(RoleRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function index()
    {
        $roles = $this->repository->getAll();

        return view('acl::acl_list', ['roles' => $roles]);
    }
}
