<?php

namespace App\Module\User\Providers;

use App\Module\User\Middleware\EditDepart;
use App\Module\User\Middleware\EditGroup;
use App\Module\User\Middleware\ListDepart;
use App\Module\User\Middleware\ListGroup;
use App\Module\User\Middleware\EditUser;
use App\Module\User\Middleware\ListUser;
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
        $this->aliasMiddleware('user.list', ListUser::class);
        $this->aliasMiddleware('user.edit', EditUser::class);
        $this->aliasMiddleware('group.list', ListGroup::class);
        $this->aliasMiddleware('group.edit', EditGroup::class);
        $this->aliasMiddleware('depart.list', ListDepart::class);
        $this->aliasMiddleware('depart.edit', EditDepart::class);
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
