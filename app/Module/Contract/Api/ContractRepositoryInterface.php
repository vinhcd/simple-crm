<?php

namespace App\Module\Contract\Api;

use App\Module\Contract\Api\Data\ContractInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ContractRepositoryInterface
{
    /**
     * @return ContractInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return ContractInterface
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
     * @param ContractInterface $contract
     * @return bool
     * @throws \Exception
     */
    public function save($contract);

    /**
     * @param ContractInterface $contract
     * @return bool
     * @throws \Exception
     */
    public function delete($contract);
}
