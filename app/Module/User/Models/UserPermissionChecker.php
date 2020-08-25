<?php

namespace App\Module\User\Models;

use App\Module\Acl\Api\AclCheckerInterface;
use App\Module\User\Api\UserPermissionCheckerInterface;
use App\Module\User\Models\Data\User;
use Illuminate\Support\Facades\Auth;

/**
 * Singleton Class UserPermissionChecker
 */
class UserPermissionChecker implements UserPermissionCheckerInterface
{
    /**
     * @var User
     */
    private $user;

    /**
     * @var array
     */
    private $reads = [];

    /**
     * @var array
     */
    private $writes = [];

    /**
     * PermissionChecker constructor.
     */
    public function __construct()
    {
        $this->user = Auth::user();
    }

    /**
     * @param string $resourceId
     * @param string $module
     * @return bool
     */
    public function canRead($resourceId, $module)
    {
        if (!isset($this->reads[$module][$resourceId])) {
            /* @var AclCheckerInterface $aclChecker */
            $aclChecker = app(AclCheckerInterface::class);
            $aclChecker->setUser($this->user);
            $aclChecker->addResource($resourceId, $module);

            $this->reads[$module][$resourceId] = $aclChecker->canRead();
        }
        return $this->reads[$module][$resourceId];
    }

    /**
     * @param string $resourceId
     * @param string $module
     * @return bool
     */
    public function canWrite($resourceId, $module)
    {
        if (!isset($this->writes[$module][$resourceId])) {
            /* @var AclCheckerInterface $aclChecker */
            $aclChecker = app(AclCheckerInterface::class);
            $aclChecker->setUser($this->user);
            $aclChecker->addResource($resourceId, $module);

            $this->writes[$module][$resourceId] = $aclChecker->canWrite();
        }
        return $this->writes[$module][$resourceId];
    }
}
