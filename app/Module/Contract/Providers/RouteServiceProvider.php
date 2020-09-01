<?php

namespace App\Module\Contract\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * @var string
     */
    protected $namespace = 'App\Module\Contract\Controllers';

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
    public function registerMiddleWare(){}

    /**
     * @return void
     */
    public function map()
    {
        $this->mapWebRoutes();
//        $this->mapApiRoutes();
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

    /**
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::middleware('api')
            ->namespace($this->namespace)
            ->group(__DIR__ . '/../routes/api.php');
    }
}
