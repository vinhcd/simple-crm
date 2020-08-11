<?php

namespace App\Module\Manager\Providers;

use App\Module\Manager\Middleware\Acl;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Module\Manager\Controllers';

    /**
     * @inheritDoc
     */
    public function boot()
    {
        parent::boot();

        $this->registerMiddleWare();
    }

    /**
     * @return void
     */
    public function registerMiddleWare()
    {
        $this->aliasMiddleware('manager.acl', Acl::class);
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
