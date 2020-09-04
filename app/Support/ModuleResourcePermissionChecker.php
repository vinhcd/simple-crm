<?php

namespace App\Support;

use App\Module\Contract\Api\Data\ContractInterface;
use App\Module\Contract\ContractServiceProvider;
use App\Module\Manager\Api\Data\OrderInterface;
use App\Module\Manager\Api\Data\OrganizationInterface;
use App\Module\Manager\Api\Data\PlanInterface;
use App\Module\Manager\ManagerServiceProvider;
use App\Module\User\Api\Data\DepartmentInterface;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\PositionInterface;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\UserPermissionCheckerInterface;
use App\Module\User\UserServiceProvider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class ModuleResourcePermissionChecker
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
    public function canReadOrganizations()
    {
        return $this->userPermissionChecker->canRead(OrganizationInterface::RESOURCE_ID, ManagerServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditOrganizations()
    {
        return Auth::user()->isSuperAdmin() && Config::get('app.neos_subdomain') == SUBDOMAIN;
    }

    /**
     * @return bool
     */
    public function canReadPlans()
    {
        return $this->userPermissionChecker->canRead(PlanInterface::RESOURCE_ID, ManagerServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditPlans()
    {
        return Auth::user()->isSuperAdmin() && Config::get('app.neos_subdomain') == SUBDOMAIN;
    }

    /**
     * @return bool
     */
    public function canReadOrders()
    {
        return $this->userPermissionChecker->canRead(OrderInterface::RESOURCE_ID, ManagerServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditOrders()
    {
        return Auth::user()->isSuperAdmin() && Config::get('app.neos_subdomain') == SUBDOMAIN;
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
    public function canReadPositions()
    {
        return $this->userPermissionChecker->canRead(PositionInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditPositions()
    {
        return $this->userPermissionChecker->canWrite(PositionInterface::RESOURCE_ID, UserServiceProvider::MODULE_NAME);
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

    /**
     * @return bool
     */
    public function canReadContracts()
    {
        return $this->userPermissionChecker->canRead(ContractInterface::RESOURCE_ID, ContractServiceProvider::MODULE_NAME);
    }

    /**
     * @return bool
     */
    public function canEditContracts()
    {
        return $this->userPermissionChecker->canWrite(ContractInterface::RESOURCE_ID, ContractServiceProvider::MODULE_NAME);
    }
}
