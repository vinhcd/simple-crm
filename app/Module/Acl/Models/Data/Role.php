<?php

namespace App\Module\Acl\Models\Data;

use App\Models\AbstractModel;
use App\Module\Acl\Api\Data\RoleInterface;
use App\Module\Acl\Api\Data\RolePermissionInterface;
use App\Module\User\Api\Data\GroupInterface;
use App\Module\User\Api\Data\UserInterface;
use App\Module\User\Api\GroupRepositoryInterface;
use App\Module\User\Api\UserRepositoryInterface;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
            $roleUsers = $this->users()->get();
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
     * @return RoleGroup[]
     */
    public function getGroups()
    {
        if (!$this->groups) {
            $roleGroups = $this->groups()->get();
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
     * @return RolePermissionInterface[]
     */
    public function getPermissions()
    {
        if (!$this->permissions) {
            $this->permissions = $this->permissions()->get()->toArray();
        }
        return $this->permissions;
    }

    /**
     * @return HasMany
     */
    public function users()
    {
        return $this->hasMany(RoleUser::class);
    }

    /**
     * @return HasMany
     */
    public function groups()
    {
        return $this->hasMany(RoleGroup::class);
    }

    /**
     * @return HasMany
     */
    public function permissions()
    {
        return $this->hasMany(RolePermission::class);
    }
}
