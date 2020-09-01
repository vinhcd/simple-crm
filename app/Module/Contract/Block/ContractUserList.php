<?php

namespace App\Module\Contract\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Models\ContractUserRepository;
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
        $userContractedIds = [];
        $usersContracted = $this->repository->getBuilder()->with(['contract', 'template'])->get();
        foreach ($usersContracted as $item) {
            $usersData[$item->getId()]['id'] = $item->getId();
            $usersData[$item->getId()]['start'] = $item->getStart();
            $usersData[$item->getId()]['end'] = $item->getEnd();
            $usersData[$item->getId()]['active'] = $item->getActive();
            $usersData[$item->getId()]['username'] = '';
            $usersData[$item->getId()]['contract'] = $item->contract->getName();
            $usersData[$item->getId()]['template'] = $item->template->getName();
            $userContractedIds[] = $item->getId();
        }
        $users = $this->userRepository->getByIds($userContractedIds);
        foreach ($users as $user) {
            $usersData[$user->getId()]['username'] = $user->getFullName();
        }
        return $usersData;
    }
}
