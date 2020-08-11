<?php

namespace App\Module\Manager\Middleware;

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
        if (false) throw new \Exception('test');

        return $next($request);
    }
}
