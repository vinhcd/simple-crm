<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;
use App\Module\Acl\Api\Data\RoleInterface;
use App\Module\Acl\Api\Data\RolePermissionInterface;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\GroupRepositoryInterface;
use App\Module\User\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method integer getActive()
 * @method $this setActive(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Role extends AbstractModel implements RoleInterface
{
    /**
     * @var string
     */
    protected $table = 'role';

    /**
     * automatically get/set properties
     *
     * @var string[]
     */
    protected $properties = ['name', 'active', 'description'];

    /**
     * @var UserInterface[]
     */
    protected $users = [];

    /**
     * @var GroupInterface[]
     */
    protected $groups = [];

    /**
     * @var RolePermissionInterface[]
     */
    protected $permissions = [];

    /**
     * @var UserRepositoryInterface
     */
    protected $userRepository;

    /**
     * @var GroupRepositoryInterface
     */
    protected $groupRepository;

    /**
     * Role constructor.
     * @param UserRepositoryInterface $userRepository
     * @param GroupRepositoryInterface $groupRepository
     * @param array $attributes
     */
    public function __construct(
        UserRepositoryInterface $userRepository,
        GroupRepositoryInterface $groupRepository,
        array $attributes = []
    )
    {
        $this->userRepository = $userRepository;
        $this->groupRepository = $groupRepository;

        parent::__construct($attributes);
    }

    /**
     * @return RoleUser[]
     */
    public function getUsers()
    {
        if (!$this->users) {
            $roleUsers = $this->hasMany(RoleUser::class)->get();
            $ids = [];
            /* @var RoleUser $roleUser */
            foreach ($roleUsers as $roleUser) {
                $ids[] = $roleUser->getId();
            }
            $this->users = $this->userRepository->getByIds($ids)->toArray();
        }
        return $this->users;
    }

    /**
     * @param UserInterface[] $users
     * @return $this
     */
    public function setUsers($users)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * @return RoleGroup[]
     */
    public function getGroups()
    {
        if (!$this->groups) {
            $roleGroups = $this->hasMany(RoleGroup::class)->get();
            $ids = [];
            /* @var RoleGroup $roleGroup */
            foreach ($roleGroups as $roleGroup) {
                $ids[] = $roleGroup->getId();
            }
            $this->groups = $this->groupRepository->getByIds($ids)->toArray();
        }
        return $this->groups;
    }

    /**
     * @param GroupInterface[] $groups
     * @return $this
     */
    public function setGroups($groups)
    {
        $this->groups = $groups;

        return $this;
    }

    /**
     * @return RolePermissionInterface[]
     */
    public function getPermissions()
    {
        if (!$this->permissions) {
            $this->permissions = $this->hasMany(RolePermission::class)->get()->toArray();
        }
        return $this->permissions;
    }

    /**
     * @param RolePermissionInterface[] $permissions
     * @return $this
     */
    public function setPermissions($permissions)
    {
        $this->permissions = $permissions;

        return $this;
    }
}
