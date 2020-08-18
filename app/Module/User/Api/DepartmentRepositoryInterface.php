<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Data\DepartmentInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface DepartmentRepositoryInterface
{
    /**
     * @return DepartmentInterface
     */
    public function create();

    /**
     * @param int $id
     * @return DepartmentInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param int[] $ids
     * @return DepartmentInterface[] | Collection
     */
    public function getByIds($ids);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return DepartmentInterface[] | Collection
     */
    public function getAll();

    /**
     * @param DepartmentInterface $department
     * @return bool
     * @throws \Exception
     */
    public function save($department);

    /**
     * @param DepartmentInterface $department
     * @return bool
     * @throws \Exception
     */
    public function delete($department);
}
