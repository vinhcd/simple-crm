<?php

namespace App\Module\Contract\Models;

use App\Module\Contract\Api\ContractRepositoryInterface;
use App\Module\Contract\Models\Data\Contract;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractRepository implements ContractRepositoryInterface
{
    /**
     * @return Contract
     */
    public function create()
    {
        return new Contract();
    }

    /**
     * @param int $id
     * @return Contract
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return Contract::findOrFail($id);
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return Contract::query();
    }

    /**
     * @return Contract[]|Collection
     */
    public function getAll()
    {
        return Contract::all();
    }

    /**
     * @param Contract $contract
     * @return bool
     * @throws \Exception
     */
    public function save($contract)
    {
        return $contract->save();
    }

    /**
     * @param Contract $contract
     * @return bool
     * @throws \Exception
     */
    public function delete($contract)
    {
        return $contract->delete();
    }
}
