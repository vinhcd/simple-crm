<?php

namespace App\Module\User\Middleware;

use Closure;
use Illuminate\Http\Request;

class Acl
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        return $next($request);
    }
}
