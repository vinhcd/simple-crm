<?php

namespace App\Module\User\Middleware;

use App\Module\Acl\Api\AclCheckerInterface;
use App\Module\User\Models\Data\User;
use Closure;
use Illuminate\Http\Request;

class Acl
{
    /**
     * @var AclCheckerInterface
     */
    private $aclChecker;

    /**
     * Acl constructor.
     * @param AclCheckerInterface $aclChecker
     */
    public function __construct(AclCheckerInterface $aclChecker)
    {
        $this->aclChecker = $aclChecker;
    }

    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        $this->aclChecker->setUser(auth()->user());
        $this->aclChecker->addResource(User::RESOURCE_ID);
        if (!$this->aclChecker->canRead()) {
            throw new \Exception(__('You dont have enough permission'));
        }
        return $next($request);
    }
}
