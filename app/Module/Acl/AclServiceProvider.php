<?php

namespace App\Module\Acl;

use App\Helper\InjectionHelper;
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

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->bindInjection();
    }

    /**
     * @return void
     */
    private function bindInjection()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/injection.php', InjectionHelper::KEY);

        InjectionHelper::bind('acl');
    }
}
