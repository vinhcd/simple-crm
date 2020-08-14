<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use \App\Module\User\Models\Data\User;
use Illuminate\Support\Facades\Hash;

$factory->define(User::class, function () {
    return [
        'name' => 'neos',
        'email' => 'neos@neoscorp.vn',
        'email_verified_at' => now(),
        'password' => Hash::make('neos'),
        'created_at' => now(),
        'updated_at' => now(),
    ];
});
