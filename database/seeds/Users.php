<?php

use Illuminate\Database\Seeder;

class Users extends Seeder
{
    /**
     * @return void
     */
    public function run()
    {
        factory(\App\Module\User\Models\Data\User::class)->create();
        factory(\App\Module\User\Models\Data\Group::class)->create();
        factory(\App\Module\User\Models\Data\UserInfo::class)->create();
        factory(\App\Module\User\Models\Data\UserGroup::class)->create();
    }
}
