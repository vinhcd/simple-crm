<?php

namespace App\Support;

use App\Module\User\Api\Data\DepartmentInterface;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\UserPermissionCheckerInterface;
use App\Module\User\UserServiceProvider;

class PermissionChecker
{
    /**
     * @var UserPermissionCheckerInterface
     */
    private $userPermissionChecker;

    /**
     * PermissionChecker constructor.
     */
    public function __construct()
    {
        $this->userPermissionChecker = app(UserPermissionCheckerInterface::class);
    }

    /**
     * @return bool
     */
    public function canReadUsers()
    {
        return $this->userPermissionChecker->canRead(UserInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditUsers()
    {
        return $this->userPermissionChecker->canWrite(UserInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canReadGroups()
    {
        return $this->userPermissionChecker->canRead(GroupInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditGroups()
    {
        return $this->userPermissionChecker->canWrite(GroupInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canReadDepartments()
    {
        return $this->userPermissionChecker->canRead(DepartmentInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditDepartments()
    {
        return $this->userPermissionChecker->canWrite(DepartmentInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }
}
