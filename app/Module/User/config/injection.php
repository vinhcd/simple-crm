<?php

use App\Module\User\UserServiceProvider;

return [
    UserServiceProvider::MODULE_NAME => [
        \App\Module\User\Api\Data\UserInterface::class => \App\Module\User\Models\Data\User::class,
        \App\Module\User\Api\Data\GroupInterface::class => \App\Module\User\Models\Data\Group::class,
        \App\Module\User\Api\Data\DepartmentInterface::class => \App\Module\User\Models\Data\Department::class,

        \App\Module\User\Api\UserRepositoryInterface::class => \App\Module\User\Models\UserRepository::class,
        \App\Module\User\Api\GroupRepositoryInterface::class => \App\Module\User\Models\GroupRepository::class,
        \App\Module\User\Api\DepartmentRepositoryInterface::class => \App\Module\User\Models\DepartmentRepository::class,
    ]
];
