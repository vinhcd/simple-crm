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
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
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
}
