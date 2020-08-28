<?php

namespace App\Module\Manager\Providers;

use App\Module\Manager\Middleware\CheckApiKey;
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
        $this->aliasMiddleware('manager.apikey', CheckApiKey::class);
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

    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/api.php');
    }
}
