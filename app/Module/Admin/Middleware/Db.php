<?php

namespace App\Module\Admin\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Db
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Session::has('database')) {
            \Illuminate\Support\Facades\DB::setDefaultConnection(env('DB_CONNECTION', 'mysql'));
        }
        return $next($request);
    }
}
