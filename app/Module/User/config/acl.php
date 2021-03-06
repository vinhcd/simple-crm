<?php

use App\Module\User\UserServiceProvider;

return [
    UserServiceProvider::MODULE_NAME => [
        'resources' => [
            \App\Module\User\Api\Data\UserInterface::RESOURCE_ID,
            \App\Module\User\Api\Data\GroupInterface::RESOURCE_ID,
            \App\Module\User\Api\Data\PositionInterface::RESOURCE_ID,
            \App\Module\User\Api\Data\DepartmentInterface::RESOURCE_ID,
        ]
    ]
];
