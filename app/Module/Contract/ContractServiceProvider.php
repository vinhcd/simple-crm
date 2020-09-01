<?php

namespace App\Module\Contract;

use App\Module\Contract\Providers\RouteServiceProvider;
use App\Support\Injection;
use Illuminate\Support\ServiceProvider;

class ContractServiceProvider extends ServiceProvider
{
    const MODULE_NAME = 'contract';

    /**
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/acl.php', 'acl');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadFactoriesFrom(__DIR__ . '/database/factories');
        $this->loadJsonTranslationsFrom(__DIR__ . '/resources/lang');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'contract');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('js/contract'),
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
        $this->mergeConfigFrom(__DIR__ . '/config/injection.php', Injection::KEY);

        Injection::bind(self::MODULE_NAME);
    }
}
