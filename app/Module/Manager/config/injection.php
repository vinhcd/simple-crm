<?php

use App\Module\Manager\ManagerServiceProvider;

return [
    ManagerServiceProvider::MODULE_NAME => [
        \App\Module\Manager\Api\Data\PlanInterface::class => \App\Module\Manager\Models\Data\Plan::class,
        \App\Module\Manager\Api\Data\OrderInterface::class => \App\Module\Manager\Models\Data\PlanOrder::class,
        \App\Module\Manager\Api\Data\OrganizationInterface::class => \App\Module\Manager\Models\Data\Organization::class,

        \App\Module\Manager\Api\PlanRepositoryInterface::class => \App\Module\Manager\Models\PlanRepository::class,
        \App\Module\Manager\Api\OrderRepositoryInterface::class => \App\Module\Manager\Models\OrderRepository::class,
        \App\Module\Manager\Api\OrganizationRepositoryInterface::class => \App\Module\Manager\Models\OrganizationRepository::class,
    ]
];
