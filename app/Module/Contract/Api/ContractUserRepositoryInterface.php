<?php

namespace App\Module\Contract\Api;

use App\Module\Contract\Api\Data\ContractUserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ContractUserRepositoryInterface
{
    /**
     * @return ContractUserInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return ContractUserInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param int $userId
     * @return ContractUserInterface|null
     */
    public function getActiveContractForUser($userId);

    /**
     * @param int[] $userIds
     * @return ContractUserInterface[]|Collection
     */
    public function getActiveContractsForUsers($userIds);

    /**
     * @param int $userId
     * @return ContractUserInterface[]|Collection
     */
    public function getContractHistoryForUser($userId);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param ContractUserInterface $contractUser
     * @return bool
     * @throws \Exception
     */
    public function save($contractUser);

    /**
     * @param ContractUserInterface $contractUser
     * @return bool
     * @throws \Exception
     */
    public function delete($contractUser);
}
