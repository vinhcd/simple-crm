<?php

namespace App\Module\Acl\Api;

use App\Module\Acl\Api\Data\RoleInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface RoleRepositoryInterface
{
    /**
     * @return RoleInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return RoleInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @return Collection
     */
    public function getActiveRoles();

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param RoleInterface $role
     * @return bool
     * @throws \Exception
     */
    public function save($role);

    /**
     * @param RoleInterface $role
     * @return bool
     * @throws \Exception
     */
    public function delete($role);
}
