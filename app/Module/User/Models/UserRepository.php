<?php

namespace App\Module\User\Models;

use App\Module\User\Api\UserRepositoryInterface;
use App\Module\User\Models\Data\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

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
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return User::findOrFail($id);
    }

    /**
     * @param int[] $ids
     * @return User[]|Collection
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
        return User::query();
    }

    /**
     * @return User[]|Collection
     */
    public function getAll()
    {
        return User::where('deleted', 0)->get();
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
        $user->setDeleted(1);

        return $user->save();
    }

    /**
     * @param int $id
     * @return User
     * @throws ModelNotFoundException
     * @throws \Exception
     */
    public function recover($id)
    {
        $user = $this->getById($id);
        $user->setDeleted(0);
        $this->save($user);

        return $user;
    }

    /**
     * @param User $user
     * @return bool
     * @throws \Exception
     */
    public function hardDelete($user)
    {
        return $user->delete();
    }
}
