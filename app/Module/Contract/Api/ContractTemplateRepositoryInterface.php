<?php

namespace App\Module\Contract\Api;

use App\Module\Contract\Api\Data\ContractTemplateInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface ContractTemplateRepositoryInterface
{
    /**
     * @return ContractTemplateInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return ContractTemplateInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param int $id
     * @return ContractTemplateInterface[]|Collection
     */
    public function getByContractId($id);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param ContractTemplateInterface $contractTemplate
     * @return bool
     * @throws \Exception
     */
    public function save($contractTemplate);

    /**
     * @param ContractTemplateInterface $contractTemplate
     * @return bool
     * @throws \Exception
     */
    public function delete($contractTemplate);
}
