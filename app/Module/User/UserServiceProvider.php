<?php

namespace App\Module\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        //$this->loadFactoriesFrom(__DIR__ . '/factories');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'user');
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
        $this->addMiddleWares();
    }

    /**
     * @return void
     */
    private function addMiddleWares()
    {
        $this->app['router']->aliasMiddleware('user.auth', \App\Module\User\Middleware\Auth::class);
    }
}
