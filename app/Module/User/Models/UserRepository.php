<?php

namespace App\Module\User\Models;

use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Models\Data\User;

class UserRepository implements UserRepositoryInterface
{
    /**
     * @return User
     */
    public function create()
    {
        return new User();
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getBuilder()
    {
        return User::query();
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return User::all();
    }

    /**
     * @param User $user
     * @return bool
     */
    public function save($user)
    {
        return $user->save();
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function delete($user)
    {
        return $user->delete();
    }
}
