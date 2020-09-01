<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\ContractRepository;
use App\Module\Contract\Models\Data\Contract;
use Illuminate\Support\Facades\Request;

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

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $contract = $this->getContract();
        $contract->setName($posts['name']);
        $contract->setType($posts['type'] ?: '');
        $contract->setDescription($posts['description'] ?: '');

        (new ContractRepository())->save($contract);
    }
}
