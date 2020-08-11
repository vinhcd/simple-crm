<?php

namespace App\Module\Manager;

use App\Module\Manager\Providers\RouteServiceProvider;
use Illuminate\Support\ServiceProvider;

class ManagerServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
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
        $this->bindImplementations();
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
