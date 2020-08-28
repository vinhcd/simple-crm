<?php

namespace App\Module\Manager\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckApiKey
{
    /**
     * @TODO: implement api key check
     *
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $apiKey = $request->input('apiKey');

        if (!$this->validate($apiKey)) throw new \Exception(__('Invalid API Key'));

        return $next($request);
    }

    /**
     * @param string $key
     * @return bool
     */
    private function validate($key)
    {
        //todo: implement method

        return true;
    }
}
