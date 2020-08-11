<?php

namespace App\Module\Acl;

use Illuminate\Support\ServiceProvider;

class AclServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/database/factories');
        $this->loadJsonTranslationsFrom(__DIR__ . '/resources/lang');
    }
}
