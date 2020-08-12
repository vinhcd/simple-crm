<?php

namespace App\Module\Manager;

use App\Helper\InjectionHelper;
use App\Module\Manager\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/acl.php', 'acl');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/database/factories');
        $this->loadJsonTranslationsFrom(__DIR__ . '/resources/lang');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'manager');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('js/manager'),
        ], 'public');
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
        $this->mergeConfigFrom(__DIR__ . '/config/injection.php', InjectionHelper::KEY);

        InjectionHelper::bind('manager');
    }
}
