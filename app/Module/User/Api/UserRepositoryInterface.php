<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Data\UserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface UserRepositoryInterface
{
    /**
     * @return UserInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return UserInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param int[] $ids
     * @return UserInterface[] | Collection
     */
    public function getByIds($ids);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return UserInterface[] | Collection
     */
    public function getAll();

    /**
     * @param UserInterface $user
     * @return bool
     * @throws \Exception
     */
    public function save($user);

    /**
     * @param UserInterface $user
     * @return bool
     * @throws \Exception
     */
    public function delete($user);

    /**
     * @param int $id
     * @return UserInterface
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function recover($id);

    /**
     * @param UserInterface $user
     * @return bool
     * @throws \Exception
     */
    public function hardDelete($user);
}
