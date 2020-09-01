<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractTemplateInterface;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @method int getId()
 * @method int getContractId()
 * @method $this setContractId(int $value)
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getContent()
 * @method $this setContent(string $value)
 */
class ContractTemplate extends AbstractModel implements ContractTemplateInterface
{
    /**
     * @var string
     */
    protected $table = 'contract_template';

    /**
     * @var string[]
     */
    protected $properties = ['contract_id', 'name', 'content'];

    /**
     * @return BelongsTo
     */
    public function contract()
    {
        return $this->belongsTo(Contract::class);
    }
}
