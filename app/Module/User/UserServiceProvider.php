<?php

namespace App\Module\User;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $controllerNamespace = '\App\Module\User\Controllers';

    /**
     * @return void
     */
    public function boot()
    {
//        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        //$this->loadFactoriesFrom(__DIR__ . '/factories');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'user');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'user');

//        $this->publishes([
//            __DIR__ . '/resources/js' => public_path('js/user'),
//        ], 'public');
    }

    /**
     * @return void
     */
    public function loadRoutes()
    {
        Route::middleware('web')
            ->namespace($this->controllerNamespace)
            ->group(__DIR__ . '/routes/web.php');
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
//        $this->app['router']->aliasMiddleware('user.auth', \App\Module\User\Middleware\Auth::class);
    }
}
