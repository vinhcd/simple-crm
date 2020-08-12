<?php

namespace App\Module\Acl\Models;

use App\Module\Acl\Api\RoleRepositoryInterface;
use App\Module\Acl\Models\Data\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class RoleRepository implements RoleRepositoryInterface
{
    /**
     * @return Role
     */
    public function create()
    {
        return new Role();
    }

    /**
     * @param int $id
     * @return Role
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return Role::findOrFail($id);
    }

    /**
     * @return Collection
     */
    public function getActiveRoles()
    {
        return Role::where(['active' => 1])->get();
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return Role::query();
    }

    /**
     * @return Collection
     */
    public function getAll()
    {
        return Role::all();
    }

    /**
     * @param Role $role
     * @return bool
     */
    public function save($role)
    {
        return $role->save();
    }

    /**
     * @param Role $role
     * @return bool
     * @throws \Exception
     */
    public function delete($role)
    {
        return $role->delete();
    }
}
