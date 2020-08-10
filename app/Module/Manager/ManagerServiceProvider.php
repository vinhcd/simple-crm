<?php

namespace App\Module\Manager;

use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/routes.php');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        //$this->loadFactoriesFrom(__DIR__ . '/factories');
        $this->loadTranslationsFrom(__DIR__ . '/resources/lang', 'manager');
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
        $this->addMiddleWares();
        $this->bindImplementations();
    }

    /**
     * @return void
     */
    private function addMiddleWares()
    {
    }

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
