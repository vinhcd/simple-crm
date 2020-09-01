<?php

namespace App\Module\Contract\Api\Data;

/**
 * @method int getId()
 * @method int getContractId()
 * @method $this setContractId(int $value)
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getContent()
 * @method $this setContent(string $value)
 */
interface ContractTemplateInterface
{
    const RESOURCE_ID = 'contract_template';
}
