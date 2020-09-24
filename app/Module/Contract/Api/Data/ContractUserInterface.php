<?php

namespace App\Module\Contract\Api\Data;

/**
 * @method int getId()
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method int getContractId()
 * @method $this setContractId(int $value)
 * @method int getTemplateId()
 * @method $this setTemplateId(int $value)
 * @method string getUsername()
 * @method $this setUsername(string $value)
 * @method string getStart()
 * @method $this setStart(string $value)
 * @method string getEnd()
 * @method $this setEnd(string $value)
 * @method int getActive()
 * @method $this setActive(int $value)
 */
interface ContractUserInterface
{
    const RESOURCE_ID = 'contract_user';

    /**
     * @return ContractInterface
     */
    public function getContract();

    /**
     * @return ContractTemplateInterface
     */
    public function getTemplate();

    /**
     * @return string
     */
    public function getSalary();

    /**
     * @param string $value
     * @return string
     * @throws \Exception
     */
    public function setSalary($value);
}
