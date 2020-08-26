<?php

namespace App\Module\Acl\Providers;

use App\Module\Acl\Middleware\ManageRole;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Module\Acl\Controllers';

    /**
     * @inheritDoc
     */
    public function boot()
    {
        parent::boot();

        $this->aliasMiddleware('role.manage', ManageRole::class);
    }

    /**
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
    }

    /**
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/web.php');
    }
}
