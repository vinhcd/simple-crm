<?php

namespace App\Module\Acl\Controllers;

use App\Http\Controllers\Controller;
use App\Module\Acl\Api\RoleRepositoryInterface;
use App\Module\Acl\Block\RoleEdit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RoleController extends Controller
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

        return view('acl::role_list', ['roles' => $roles]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $role = $id ? $this->repository->getById($id) : $this->repository->create();

        $roleEditBlock = new RoleEdit($role);

        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
            ]);
            try {
                $roleEditBlock->update();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Role :role has been updated!', ['role' => $role->getName()]));

            return redirect()->route('role_create_update', ['id' => $role->getId()]);
        }
        return view('acl::role_create', ['roleEditBlock' => $roleEditBlock]);
    }
}
