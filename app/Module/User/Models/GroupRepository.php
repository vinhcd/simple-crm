<?php

namespace App\Module\User\Models;

use App\Module\User\Api\GroupRepositoryInterface;
use App\Module\User\Models\Data\Group;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GroupRepository implements GroupRepositoryInterface
{
    /**
     * @return Group
     */
    public function create()
    {
        return new Group();
    }
    /**
     * @return Group
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return Group::findOrFail($id);
    }

    /**
     * @param int[] $ids
     * @return Group[]|Collection
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
        return Group::query();
    }

    /**
     * @return Group[]|Collection
     */
    public function getAll()
    {
        return Group::all();
    }

    /**
     * @param Group $group
     * @return bool
     */
    public function save($group)
    {
        return $group->save();
    }

    /**
     * @param Group $group
     * @return bool
     * @throws \Exception
     */
    public function delete($group)
    {
        return $group->delete();
    }
}
