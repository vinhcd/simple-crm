<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Module\User\Models\Data\UserInfo;

$factory->define(UserInfo::class, function () {
    return [
        'user_id' => 1,
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
