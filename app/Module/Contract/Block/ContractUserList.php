<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\ContractUserRepository;
use App\Module\Contract\Models\Data\ContractUser;
use App\Module\User\Api\UserRepositoryInterface;

class ContractUserList extends AbstractBlock
{
    /**
     * @var ContractUserRepository
     */
    private $repository;

    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * ContractUserList constructor.
     */
    public function __construct()
    {
        $this->repository = new ContractUserRepository;
        $this->userRepository = app(UserRepositoryInterface::class);
    }

    /**
     * @return array
     */
    public function getUsersData()
    {
        $usersData = [];
        $usersContracted = $this->repository->getBuilder()->with(['contract', 'template'])->get();
        /* @var ContractUser $item */
        foreach ($usersContracted as $item) {
            $usersData[$item->getId()]['id'] = $item->getId();
            $usersData[$item->getId()]['start'] = $item->getStart();
            $usersData[$item->getId()]['end'] = $item->getEnd();
            $usersData[$item->getId()]['salary'] = $item->getSalary();
            $usersData[$item->getId()]['active'] = $item->getActive();
            $usersData[$item->getId()]['username'] = $item->getUsername();
            $usersData[$item->getId()]['contract'] = $item->contract->getName();
            $usersData[$item->getId()]['template'] = $item->template->getName();
        }
        return $usersData;
    }
}
