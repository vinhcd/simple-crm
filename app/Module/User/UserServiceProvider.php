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
        $this->app['router']->middleware('user.auth', \App\Module\User\Middleware\Auth::class);
    }
}
