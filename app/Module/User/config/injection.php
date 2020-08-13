<?php

return [
    'user' => [
        \App\Module\User\Api\Data\UserInterface::class => \App\Module\User\Models\Data\User::class,

        \App\Module\User\Api\UserRepositoryInterface::class => \App\Module\User\Models\UserRepository::class,
    ]
];
