<?php

namespace App\Module\User\Controllers;

use App\Http\Controllers\Controller;
use App\Module\User\Api\Data\DepartmentInterface;
use App\Module\User\Api\DepartmentRepositoryInterface;
use App\Module\User\Block\DepartEdit;
use App\Module\User\Models\Data\Department;
use App\Module\User\Models\Data\UserDepartment;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DepartmentController extends Controller
{
    /**
     * @var DepartmentRepositoryInterface
     */
    private $repository;

    /**
     * DepartmentController constructor.
     * @param DepartmentRepositoryInterface $repository
     */
    public function __construct(DepartmentRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return View
     */
    public function list()
    {
        $departments = $this->repository->getAll();

        return view('user::depart_list', ['departments' => $departments]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse|View
     */
    public function createOrUpdate(Request $request, $id = '')
    {
        $department = $id ? $this->repository->getById($id) : $this->repository->create();

        $departmentEditBlock = new DepartEdit($department);

        if ($posts = $request->post()) {
            $request->validate([
                'name' => 'required|max:255',
                'display_name' => 'required|max:255',
            ]);
            $departmentEditBlock->update();
            if ($this->isDuplicate($department)) {
                return redirect()->back()->withErrors(__('Department is already exist'));
            }
            try {
                $this->repository->save($department);
            } catch (\Exception $e) {
                return redirect()->route('user_department_create_update', ['id' => $id])->withErrors($e->getMessage());
            }
            $request->session()->flash('success', __('Department :department has been updated!', ['department' => $department->getDisplayName()]));

            return redirect()->route('user_depart_create_update', ['id' => $department->getId()]);
        }
        return view('user::depart_create', ['departmentEditBlock' => $departmentEditBlock]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return RedirectResponse
     */
    public function updateUsers(Request $request, $id = '')
    {
        if (!$id) {
            return redirect()->back()->withErrors(__('You must create department before adding users into it'));
        }
        $userIds = $request->post('users');
        $department = $this->repository->getById($id);
        try {
            DB::beginTransaction();
            UserDepartment::where('department_id', $department->getId())->delete();
            if (is_array($userIds)) {
                foreach ($userIds as $userId) {
                    $userDepartment = new UserDepartment();
                    $userDepartment->setDepartmentId($department->getId());
                    $userDepartment->setUserId($userId);
                    $userDepartment->save();
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            return redirect()->back()->withErrors($e->getMessage());
        }
        session()->flash('success', __('Department :department has been updated!', ['department' => $department->getDisplayName()]));

        return redirect()->back();
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete($id)
    {
        $department = $this->repository->getById($id);
        try {
            $this->repository->delete($department);
        } catch (\Exception $e) {
            return redirect()->route('user_depart_list')->withErrors($e->getMessage());
        }
        session()->flash('success', __('Department :department has been removed!', ['department' => $department->getDisplayName()]));

        return redirect()->route('user_depart_list');
    }

    /**
     * @param DepartmentInterface $department
     * @return bool
     */
    private function isDuplicate($department)
    {
        /* @var Department $exist */
        $exist = $this->repository->getBuilder()->where('name', $department->getName())->get()->first();
        if ($exist && ($exist->getId() != $department->getId())) return true;

        return false;
    }
}
