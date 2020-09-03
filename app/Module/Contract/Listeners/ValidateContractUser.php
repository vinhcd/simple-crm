<?php

namespace App\Module\Contract\Listeners;

use App\Module\Contract\Models\ContractUserRepository;
use App\Module\Contract\Models\Data\ContractUser;

class ValidateContractUser
{
    /**
     * @param ContractUser $contractUser
     * @return void
     * @throws \Exception
     */
    public function handle(ContractUser $contractUser)
    {
        $repo = new ContractUserRepository();
        if ($contractUser->getActive()) {
            $anotherActiveContracts = $repo->getBuilder()
                ->where('id', '!=', $contractUser->getId())
                ->where('user_id', $contractUser->getUserId())
                ->where('active', 1)
                ->get('id');
            if ($anotherActiveContracts->count()) {
                throw new \Exception(__('User cannot have more than 1 active contract'));
            }
        }
    }
}
