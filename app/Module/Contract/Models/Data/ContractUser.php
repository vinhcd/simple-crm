<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractUserInterface;

/**
 * @method int getId()
 * @method int getUserId()
 * @method $this setUserId(int $value)
 * @method int getContractId()
 * @method $this setContractId(int $value)
 * @method int getTemplateId()
 * @method $this setTemplateId(int $value)
 * @method string getStart()
 * @method string getEnd()
 * @method int getActive()
 * @method $this setActive(int $value)
 */
class ContractUser extends AbstractModel implements ContractUserInterface
{
    /**
     * @var string
     */
    protected $table = 'contract_user';

    /**
     * @var string[]
     */
    protected $properties = ['user_id', 'contract_id', 'template_id', 'start', 'end', 'active'];

    /**
     * @param string $date
     * @return $this
     */
    public function setStart($date)
    {
        $this->start = !empty($date) ? $date : null;

        return $this;
    }

    /**
     * @param string $date
     * @return $this
     */
    public function setEnd($date)
    {
        $this->end = !empty($date) ? $date : null;

        return $this;
    }
}
