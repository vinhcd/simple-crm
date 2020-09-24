<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractUserInterface;
use App\Support\Encryption;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Log;

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
     * @inheritDoc
     */
    public function getSalary()
    {
        if ($this->salary) {
            try {
                return (new Encryption())->decrypt($this->salary);
            } catch (\Exception $e) {
                Log::error($e->getMessage());
            }
        }
        return '';
    }

    /**
     * @inheritDoc
     */
    public function setSalary($value)
    {
        $this->salary = (new Encryption())->encrypt($value);

        return $this;
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
