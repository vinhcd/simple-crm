<?php

namespace App\Module\Manager;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $controllerNamespace = '\App\Module\Manager\Controllers';

    /**
     * @return void
     */
    public function boot()
    {
        $this->loadRoutes();
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'manager');
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'manager');

        $this->publishes([
            __DIR__ . '/resources/js' => public_path('js/manager'),
        ], 'public');
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
        $this->bindImplementations();
    }

    /**
     * @return void
     */
    private function addMiddleWares(){}

    /**
     * @return void
     */
    private function bindImplementations()
    {
        $this->app->bind(
            \App\Module\Manager\Api\Data\PlanInterface::class,
            \App\Module\Manager\Models\Data\Plan::class
        );
        $this->app->bind(
            \App\Module\Manager\Api\PlanRepositoryInterface::class,
            \App\Module\Manager\Models\PlanRepository::class
        );
        $this->app->bind(
            \App\Module\Manager\Api\Data\OrganizationInterface::class,
            \App\Module\Manager\Models\Data\Organization::class
        );
        $this->app->bind(
            \App\Module\Manager\Api\OrganizationRepositoryInterface::class,
            \App\Module\Manager\Models\OrganizationRepository::class
        );
    }
}
