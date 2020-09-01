<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\ContractRepository;
use App\Module\Contract\Models\ContractTemplateRepository;
use App\Module\Contract\Models\Data\ContractTemplate;
use Illuminate\Support\Facades\Request;

class ContractTemplateEdit extends AbstractBlock
{
    /**
     * @var ContractTemplate
     */
    private $contractTemplate;

    /**
     * ContractTemplateEdit constructor.
     * @param ContractTemplate $contract
     */
    public function __construct(ContractTemplate $contractTemplate)
    {
        $this->contractTemplate = $contractTemplate;
    }

    /**
     * @return ContractTemplate
     */
    public function getContractTemplate()
    {
        return $this->contractTemplate;
    }

    /**
     * @return array
     */
    public function getContracts()
    {
        $contracts = [];
        $all = (new ContractRepository())->getAll();
        foreach ($all as $item) {
            $contracts[$item->getId()]['id'] = $item->getId();
            $contracts[$item->getId()]['name'] = $item->getName();
        }
        return $contracts;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $template = $this->getContractTemplate();
        $template->setName($posts['name']);
        $template->setContractId($posts['contract_id']);
        $template->setContent($posts['content']);

        (new ContractTemplateRepository())->save($template);
    }
}
