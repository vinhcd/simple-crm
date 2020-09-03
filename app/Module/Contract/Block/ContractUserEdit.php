<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\ContractRepository;
use App\Module\Contract\Models\ContractTemplateRepository;
use App\Module\Contract\Models\ContractUserRepository;
use App\Module\Contract\Models\Data\ContractUser;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

class ContractUserEdit extends AbstractBlock
{
    /**
     * @var ContractUser
     */
    private $contractUser;

    /**
     * @var ContractUserRepository
     */
    private $repository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * @var ContractRepository
     */
    private $contractRepository;

    /**
     * @var ContractTemplateRepository
     */
    private $templateRepository;

    /**
     * ContractUserEdit constructor.
     * @param ContractUser $contractUser
     */
    public function __construct(ContractUser $contractUser)
    {
        $this->contractUser = $contractUser;
        $this->repository = new ContractUserRepository();
        $this->userRepository = app(UserRepositoryInterface::class);
        $this->contractRepository = new ContractRepository();
        $this->templateRepository = new ContractTemplateRepository();
    }

    /**
     * @return ContractUser
     */
    public function getContractUser()
    {
        return $this->contractUser;
    }

    /**
     * @return UserInterface
     */
    public function getUser()
    {
        return $this->userRepository->getById($this->getContractUser()->getUserId());
    }

    /**
     * @return UserInterface[]|Collection
     */
    public function getAllUsers()
    {
        return $this->userRepository->getAll();
    }

    /**
     * @return array
     */
    public function getContractData()
    {
        $data = [];
        $contracts = $this->contractRepository->getBuilder()->with('templates')->get();
        foreach ($contracts as $contract) {
            $data[$contract->getId()]['id'] = $contract->getId();
            $data[$contract->getId()]['name'] = $contract->getName();
            $data[$contract->getId()]['templates'] = array_map(function ($template) {
                return ['id' => $template['id'], 'name' => $template['name']];
            }, $contract->templates->toArray());
        }
        return $data;
    }

    /**
     * @return void
     * @throws \Exception
     */
    public function update()
    {
        $posts = Request::post();

        $userContract = $this->getContractUser();
        $userContract->setUserId($posts['user']);
        $userContract->setContractId($posts['contract']);
        $userContract->setTemplateId($posts['template']);
        $userContract->setUsername($this->userRepository->getById($posts['user'])->getFullName());
        $userContract->setStart($posts['start']);
        $userContract->setEnd($posts['end']);
        $userContract->setActive($posts['status']);

        $this->repository->save($userContract);
    }
}
