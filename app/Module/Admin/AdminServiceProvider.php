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
        $this->addMiddleWares();
        $this->bindImplementations();
    }

    /**
     * @return void
     */
    private function addMiddleWares()
    {
        $this->app['router']->aliasMiddleware('admin.db', \App\Module\Admin\Middleware\Db::class);
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
        $this->app->bind(
            \App\Module\Admin\Api\Data\DatabaseInterface::class,
            \App\Module\Admin\Models\Data\Database::class
        );
        $this->app->bind(
            \App\Module\Admin\Api\DatabaseRepositoryInterface::class,
            \App\Module\Admin\Models\DatabaseRepository::class
        );
        $this->app->bind(
            \App\Module\Admin\Api\Data\OrganizationInterface::class,
            \App\Module\Admin\Models\Data\Organization::class
        );
        $this->app->bind(
            \App\Module\Admin\Api\OrganizationRepositoryInterface::class,
            \App\Module\Admin\Models\OrganizationRepository::class
        );
    }
}
