<?php

namespace App\Module\Acl\Middleware;

use App\Module\User\Api\Data\UserInterface;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ManageRole
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        /* @var UserInterface $user */
        $user = Auth::user();
        if (!$user->isSuperAdmin()) {
            return redirect()->route('home')->withErrors(__('Access denied'));
        }
        return $next($request);
    }
}
