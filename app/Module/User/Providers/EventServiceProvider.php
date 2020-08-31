<?php

namespace App\Module\User\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * @var array
     */
    protected $listen = [
        'eloquent.saving: ' . \App\Module\User\Models\Data\User::class => [
            \App\Module\User\Listeners\ValidateUserChangePermission::class
        ],
        'eloquent.deleting: ' . \App\Module\User\Models\Data\User::class => [
            \App\Module\User\Listeners\ValidateUserChangePermission::class
        ]
    ];

    /**
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
