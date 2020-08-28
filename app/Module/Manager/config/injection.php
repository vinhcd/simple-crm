<?php

use App\Module\Manager\ManagerServiceProvider;

return [
    ManagerServiceProvider::MODULE_NAME => [
        \App\Module\Manager\Api\Data\PlanInterface::class => \App\Module\Manager\Models\Data\Plan::class,
        \App\Module\Manager\Api\Data\OrganizationInterface::class => \App\Module\Manager\Models\Data\Organization::class,

        \App\Module\Manager\Api\PlanRepositoryInterface::class => \App\Module\Manager\Models\PlanRepository::class,
        \App\Module\Manager\Api\OrganizationRepositoryInterface::class => \App\Module\Manager\Models\OrganizationRepository::class,
    ]
];
