<?php

namespace App\Module\User;

use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * {@inheritDoc}
     */
    public function register()
    {
        $this->addMiddleWares();
    }

    /**
     * @return void
     */
    private function addMiddleWares()
    {
        $this->app['router']->aliasMiddleware('user.db', \App\Module\User\Middleware\Db::class);
        $this->app['router']->aliasMiddleware('user.auth', \App\Module\User\Middleware\Auth::class);
    }
}
