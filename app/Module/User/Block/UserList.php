<?php

namespace App\Module\User\Block;

use App\Block\AbstractBlock;
use App\Module\Contract\Api\ContractUserRepositoryInterface;
use App\Module\User\Models\Data\User;
use Illuminate\Database\Eloquent\Collection;

class UserList extends AbstractBlock
{
    /**
     * @var Collection
     */
    protected $list;

    /**
     * UserList constructor.
     * @param Collection $list
     */
    public function __construct($list)
    {
        $this->list = $list;
    }

    /**
     * @return array
     */
    public function getTransformedData()
    {
        $userData = [];
        $userIds = [];
        /* @var User $user */
        foreach ($this->list as $user) {
            $userData[$user->getId()] = [
                'id' => $user->getId(),
                'full_name' => $user->getFirstName() . ' ' . $user->getLastName(),
                'email' => $user->getEmail(),
                'phone' => $user->info ? $user->info->getPhone() : '',
                'contract_expire' => '',
                'groups' => implode(', ', array_map(function ($group) {
                    return $group['display_name'];
                }, $user->groups->toArray())),
                'departments' => implode(', ', array_map(function ($department) {
                    return $department['display_name'];
                }, $user->departments->toArray())),
            ];
            $userIds[] = $user->getId();
        }
        /* @var ContractUserRepositoryInterface $userContractRepo */
        $userContractRepo = app(ContractUserRepositoryInterface::class);
        $userContracts = $userContractRepo->getActiveContractsForUsers($userIds);
        foreach ($userContracts as $userContract) {
            $userData[$userContract->getUserId()]['contract_expire'] = $userContract->getEnd();
        }
        return $userData;
    }
}
