<?php

namespace App\Module\User\Providers;

use App\Module\User\Middleware\Acl;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Module\User\Controllers';

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
        $this->aliasMiddleware('user.acl', Acl::class);
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
