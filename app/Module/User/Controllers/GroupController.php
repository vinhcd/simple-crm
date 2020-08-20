<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\GroupRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GroupController extends Controller
{
    /**
     * @var GroupRepositoryInterface
     */
    private $repository;

    /**
     * GroupController constructor.
     * @param GroupRepositoryInterface $repository
     */
    public function __construct(GroupRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function list()
    {
        $groups = $this->repository->getAll();

        return view('user::group_list', ['groups' => $groups]);
    }

    public function createOrUpdate(Request $request, $id = '')
    {

    }
}
