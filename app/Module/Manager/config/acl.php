<?php

use App\Module\Manager\ManagerServiceProvider;

return [
    ManagerServiceProvider::MODULE_NAME => [
        'resources' => [
            \App\Module\Manager\Api\Data\PlanInterface::RESOURCE_ID,
            \App\Module\Manager\Api\Data\OrganizationInterface::RESOURCE_ID,
        ]
    ]
];
