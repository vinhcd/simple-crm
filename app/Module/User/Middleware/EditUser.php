<?php

namespace App\Module\User\Middleware;

use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\UserPermissionCheckerInterface;
use App\Module\User\UserServiceProvider;
use Closure;
use Illuminate\Http\Request;

class EditUser
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        /* @var UserPermissionCheckerInterface $userPermissionChecker */
        $userPermissionChecker = app(UserPermissionCheckerInterface::class);
        if (!$userPermissionChecker->canWrite(UserInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME)) {
            return redirect()->route('home')->withErrors(__('Access denied'));
        }
        return $next($request);
    }
}
