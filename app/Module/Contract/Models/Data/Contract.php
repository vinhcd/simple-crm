<?php

namespace App\Module\Contract\Models\Data;

use App\Models\AbstractModel;
use App\Module\Contract\Api\Data\ContractInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
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
    protected $properties = ['name', 'group_id', 'type', 'issue_date', 'description'];

    /**
     * @var ContractTemplate[]|Collection
     */
    protected $templates;

    /**
     * @param string $date
     * @return $this
     */
    public function setIssueDate($date)
    {
        $this->issue_date = !empty($date) ? $date : null;

        return $this;
    }

    /**
     * @return ContractTemplate[]|Collection
     */
    public function getTemplates()
    {
        if (!$this->templates) {
            $this->templates = $this->templates()->get();
        }
        return $this->templates;
    }

    /**
     * @return HasMany
     */
    public function templates()
    {
        return $this->hasMany(ContractTemplate::class);
    }
}
