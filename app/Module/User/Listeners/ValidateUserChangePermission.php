<?php

namespace App\Module\User\Listeners;

use App\Module\User\Models\Data\User;
use Illuminate\Support\Facades\Auth;

class ValidateUserChangePermission
{
    /**
     * @param User $user
     * @return void
     * @throws \Exception
     */
    public function handle(User $user)
    {
        if (!Auth::user()->isSuperAdmin() && $user->isSuperAdmin()) {
            throw new \Exception(__('You don\'t have permission to change Supper Admin user or group'));
        }
    }
}
