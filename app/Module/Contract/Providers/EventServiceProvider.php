<?php

namespace App\Module\Contract\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        'eloquent.saving: ' . \App\Module\Contract\Models\Data\ContractUser::class => [
            \App\Module\Contract\Listeners\ValidateContractUser::class
        ],
    ];
}
