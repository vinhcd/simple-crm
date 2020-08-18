<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Data\GroupInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface GroupRepositoryInterface
{
    /**
     * @return GroupInterface
     */
    public function create();

    /**
     * @param int $id
     * @return GroupInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param int[] $ids
     * @return GroupInterface[] | Collection
     */
    public function getByIds($ids);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param GroupInterface $group
     * @return bool
     */
    public function save($group);

    /**
     * @param GroupInterface $group
     * @return bool
     * @throws \Exception
     */
    public function delete($group);
}
