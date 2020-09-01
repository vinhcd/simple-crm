<?php

namespace App\Module\Contract\Models;

use App\Module\Contract\Api\ContractUserRepositoryInterface;
use App\Module\Contract\Models\Data\ContractUser;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractUserRepository implements ContractUserRepositoryInterface
{
    /**
     * @return ContractUser
     */
    public function create()
    {
        return new ContractUser();
    }

    /**
     * @param integer $id
     * @return ContractUser
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return ContractUser::findOrFail($id);
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return ContractUser::query();
    }

    /**
     * @return ContractUser[]|Collection
     */
    public function getAll()
    {
        return ContractUser::all();
    }

    /**
     * @param ContractUser $contractUser
     * @return bool
     * @throws \Exception
     */
    public function save($contractUser)
    {
        return $contractUser->save();
    }

    /**
     * @param ContractUser $contractUser
     * @return bool
     * @throws \Exception
     */
    public function delete($contractUser)
    {
        return $contractUser->delete();
    }
}
