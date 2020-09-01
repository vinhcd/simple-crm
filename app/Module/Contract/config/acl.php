<?php

use App\Module\Contract\ContractServiceProvider;

return [
    ContractServiceProvider::MODULE_NAME => [
        'resources' => [
            \App\Module\Contract\Api\Data\ContractInterface::RESOURCE_ID
        ]
    ]
];
