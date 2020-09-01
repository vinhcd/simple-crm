<?php

namespace App\Module\Contract\Models;

use App\Module\Contract\Api\ContractTemplateRepositoryInterface;
use App\Module\Contract\Models\Data\ContractTemplate;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractTemplateRepository implements ContractTemplateRepositoryInterface
{
    /**
     * @return ContractTemplate
     */
    public function create()
    {
        return new ContractTemplate();
    }

    /**
     * @param integer $id
     * @return ContractTemplate
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return ContractTemplate::findOrFail($id);
    }

    /**
     * @param int $id
     * @return ContractTemplate[]|Collection
     */
    public function getByContractId($id)
    {
        return $this->getBuilder()->where('contract_id', $id)->get();
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return ContractTemplate::query();
    }

    /**
     * @return ContractTemplate[]|Collection
     */
    public function getAll()
    {
        return ContractTemplate::query()->orderBy('contract_id')->get();
    }

    /**
     * @param ContractTemplate $contractTemplate
     * @return bool
     * @throws \Exception
     */
    public function save($contractTemplate)
    {
        return $contractTemplate->save();
    }

    /**
     * @param ContractTemplate $contractTemplate
     * @return bool
     * @throws \Exception
     */
    public function delete($contractTemplate)
    {
        return $contractTemplate->delete();
    }
}
