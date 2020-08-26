<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\User\Models\Data\Department;
use App\Module\User\Models\Data\User;
use App\Module\User\Models\Data\UserDepartment;
use App\Module\User\Models\DepartmentRepository;
use App\Module\User\Models\UserRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Request;

class DepartEdit extends AbstractBlock
{
    /**
     * @var Department
     */
    private $department;

    /**
     * @var array
     */
    private $usersData;

    /**
     * GroupEdit constructor.
     * @param Department $department
     */
    public function __construct($department)
    {
        $this->department = $department;
    }

    /**
     * @return Department
     */
    public function getDepartment()
    {
        return $this->department;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $department = $this->department;
        $department->setName($posts['name']);
        $department->setDisplayName($posts['display_name']);
        $department->setParentId($posts['parent_id'] ?: 0);
        $department->setDescription($posts['description'] ?: '');

        $this->checkDuplicate();
        $repository = new DepartmentRepository();
        $repository->save($department);

        $this->updateUsers();
    }

    /**
     * @return Department[]
     */
    public function getAllDepartments()
    {
        $departRepo = new DepartmentRepository();

        return $departRepo->getAll()->except($this->getDepartment()->getId());
    }

    /**
     * @return array
     */
    public function getUsersData()
    {
        if (!$this->usersData) {
            $userRepository = new UserRepository();
            /* @var User[] $users */
            $users = $userRepository->getBuilder()
                ->with('departments')
                ->where('deleted', 0)
                ->get(['id', 'name', 'first_name', 'last_name']);
            foreach ($users as $user) {
                $this->usersData[$user->getId()] = [
                    'id' => $user->getId(),
                    'name' => $user->getFullName() ? $user->getFullName() : $user->getName(),
                ];
                if (in_array($this->department->getId(), array_map(function ($department) {
                    return $department['id'];
                }, $user->departments->toArray()))) {
                    $this->usersData[$user->getId()]['in_department'] = true;
                } else {
                    $this->usersData[$user->getId()]['in_department'] = false;
                }
            }
        }
        return $this->usersData;
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function updateUsers()
    {
        $posts = Request::post();

        DB::beginTransaction();
        UserDepartment::where('department_id', $this->department->getId())->delete();
        if (isset($posts['users'])) {
            foreach ($posts['users'] as $userId) {
                $userDepartment = new UserDepartment();
                $userDepartment->setDepartmentId($this->department->getId());
                $userDepartment->setUserId($userId);
                $userDepartment->save();
            }
        }
        DB::commit();
    }

    /**
     * @return void
     * @throws \Exception
     */
    private function checkDuplicate()
    {
        $repository = new DepartmentRepository();

        /* @var Department $exist */
        $exist = $repository->getBuilder()->where('name', $this->department->getName())->get()->first();
        if ($exist && ($exist->getId() != $this->department->getId())) throw new \Exception(__('Department already exist'));
    }
}
