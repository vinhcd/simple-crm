<?php

namespace App\Module\User\Models;

use App\Module\User\Api\DepartmentRepositoryInterface;
use App\Module\User\Models\Data\Department;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class DepartmentRepository implements DepartmentRepositoryInterface
{
    /**
     * @return Department
     */
    public function create()
    {
        return new Department();
    }

    /**
     * @param int $id
     * @return Department
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return Department::findOrFail($id);
    }

    /**
     * @param int[] $ids
     * @return Department[]|Collection
     */
    public function getByIds($ids)
    {
        return $this->getBuilder()->whereIn('id', $ids)->get();
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return Department::query();
    }

    /**
     * @return Department[]|Collection
     */
    public function getAll()
    {
        return Department::all();
    }

    /**
     * @param Department $department
     * @return bool
     * @throws \Exception
     */
    public function save($department)
    {
        return $department->save();
    }

    /**
     * @param Department $department
     * @return bool
     * @throws \Exception
     */
    public function delete($department)
    {
        return $department->delete();
    }
}
