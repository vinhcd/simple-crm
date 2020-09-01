<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractInterface;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDisplayName()
 * @method $this setDisplayName(string $value)
 * @method int getGroupId()
 * @method $this setGroupId(int $value)
 * @method string getType()
 * @method $this setType(string $value)
 * @method string getIssueDate()
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Contract extends AbstractModel implements ContractInterface
{
    /**
     * @var string
     */
    protected $table = 'contract';

    /**
     * @var string[]
     */
    protected $properties = ['name', 'display_name', 'group_id', 'type', 'issue_date', 'description'];

    /**
     * @param string $date
     * @return $this
     */
    public function setIssueDate($date)
    {
        $this->issue_date = !empty($date) ? $date : null;

        return $this;
    }
}
