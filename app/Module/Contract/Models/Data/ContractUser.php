<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractUserInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
    protected $properties = ['user_id', 'contract_id', 'template_id', 'username', 'start', 'end', 'active'];

    /**
     * @var Contract
     */
    protected $contract;

    /**
     * @var ContractTemplate
     */
    protected $template;

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

    /**
     * @return Contract
     */
    public function getContract()
    {
        if (!$this->contract) {
            $this->contract = $this->contract()->first();
        }
        return $this->contract;
    }

    /**
     * @return ContractTemplate
     */
    public function getTemplate()
    {
        if (!$this->template) {
            $this->template = $this->template()->first();
        }
        return $this->template;
    }

    /**
     * @return BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * @return BelongsTo
     */
    public function template()
    {
        return $this->belongsTo(ContractTemplate::class, 'template_id');
    }
}
