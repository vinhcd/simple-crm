<?php

namespace App\Module\User;

use App\Helper\InjectionHelper;
use App\Module\User\Providers\EventServiceProvider;
use App\Module\User\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'user');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('js/user'),
        ], 'public');
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        $this->bindInjection();
    }

    /**
     * @return void
     */
    private function bindInjection()
    {
        $this->mergeConfigFrom(__DIR__ . '/config/injection.php', InjectionHelper::KEY);

        InjectionHelper::bind('user');
    }
}
