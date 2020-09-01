<?php

use App\Module\Contract\ContractServiceProvider;

return [
    ContractServiceProvider::MODULE_NAME => [
        \App\Module\Contract\Api\Data\ContractInterface::class => \App\Module\Contract\Models\Data\Contract::class,
        \App\Module\Contract\Api\Data\ContractTemplateInterface::class => \App\Module\Contract\Models\Data\ContractTemplate::class,
        \App\Module\Contract\Api\Data\ContractUserInterface::class => \App\Module\Contract\Models\Data\ContractUser::class,

        \App\Module\Contract\Api\ContractRepositoryInterface::class => \App\Module\Contract\Models\ContractRepository::class,
        \App\Module\Contract\Api\ContractTemplateRepositoryInterface::class => \App\Module\Contract\Models\ContractTemplateRepository::class,
        \App\Module\Contract\Api\ContractUserRepositoryInterface::class => \App\Module\Contract\Models\ContractUserRepository::class,
    ]
];
