<?php

namespace App\Module\User\Api;

interface UserPermissionCheckerInterface
{
    /**
     * @param string $resourceId
     * @param string $module
     * @return bool
     */
    public function canRead($resourceId, $module);

    /**
     * @param string $resourceId
     * @param string $module
     * @return bool
     */
    public function canWrite($resourceId, $module);
}
