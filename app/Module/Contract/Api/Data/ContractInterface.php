<?php

namespace App\Module\Contract\Api\Data;

use Illuminate\Database\Eloquent\Collection;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method int getGroupId()
 * @method $this setGroupId(int $value)
 * @method string getType()
 * @method $this setType(string $value)
 * @method string getIssueDate()
 * @method string setIssueDate(string $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
interface ContractInterface
{
    const RESOURCE_ID = 'contract';

    /**
     * @return ContractTemplateInterface[]|Collection
     */
    public function getTemplates();
}
