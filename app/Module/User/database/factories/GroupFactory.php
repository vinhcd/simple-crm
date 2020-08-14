<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Module\User\Models\Data\Group;

$factory->define(Group::class, function () {
    return [
        'name' => 'superadmin',
        'display_name' => 'Super Administrator',
        'priority' => 1,
        'description' => 'The most powerful users',
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
