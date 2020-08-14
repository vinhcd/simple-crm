<?php

return [
    'user' => [
        \App\Module\User\Api\Data\UserInterface::class => \App\Module\User\Models\Data\User::class,
        \App\Module\User\Api\Data\GroupInterface::class => \App\Module\User\Models\Data\Group::class,

        \App\Module\User\Api\UserRepositoryInterface::class => \App\Module\User\Models\UserRepository::class,
        \App\Module\User\Api\GroupRepositoryInterface::class => \App\Module\User\Models\GroupRepository::class,
    ]
];
