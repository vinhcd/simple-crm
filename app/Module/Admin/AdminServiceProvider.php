<?php

namespace App\Module\Admin;

use Illuminate\Support\ServiceProvider;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot()
    {
        //$this->loadRoutesFrom(__DIR__ . '/routes.php');
        //$this->loadMigrationsFrom(__DIR__ . '/migrations');
        //$this->loadFactoriesFrom(__DIR__ . '/factories');
        //$this->loadTranslationsFrom(__DIR__ . '/locale');
        //$this->loadViewsFrom(__DIR__ . '/views');
    }

    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->bindImplementations();
    }

    /**
     * @return void
     */
    private function bindImplementations()
    {
        $this->app->bind(
            \App\Module\Admin\Api\Data\PlanInterface::class,
            \App\Module\Admin\Models\Data\Plan::class
        );
        $this->app->bind(
            \App\Module\Admin\Api\PlanRepositoryInterface::class,
            \App\Module\Admin\Models\PlanRepository::class
        );
    }
}
