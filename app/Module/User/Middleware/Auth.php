<?php

namespace App\Module\User\Middleware;

class Auth extends \Illuminate\Auth\Middleware\Authenticate
{
    /**
     * @param \Illuminate\Http\Request $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {
            return route('login');
        }
    }
}
