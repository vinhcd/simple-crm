<?php

namespace App\Module\Acl;

use App\Module\Acl\Providers\RouteServiceProvider;
use App\Support\Injection;
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'acl');
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);

        $this->bindInjection();
    }

    /**
     * @return void
     */
    private function bindInjection()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/injection.php', Injection::KEY);

        Injection::bind('acl');
    }
}
