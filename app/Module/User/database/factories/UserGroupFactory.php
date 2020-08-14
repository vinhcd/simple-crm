<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Module\User\Models\Data\UserGroup;

$factory->define(UserGroup::class, function () {
    return [
        'user_id' => 1,
        'group_id' => 1,
        'created_by' => 1,
        'updated_by' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
