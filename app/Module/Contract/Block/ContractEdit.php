<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\Data\Contract;

class ContractEdit extends AbstractBlock
{
    /**
     * @var Contract
     */
    private $contract;

    /**
     * ContractEdit constructor.
     * @param Contract $contract
     */
    public function __construct($contract)
    {
        $this->contract = $contract;
    }

    /**
     * @return Contract
     */
    public function getContract()
    {
        return $this->contract;
    }

    public function update()
    {

    }
}
