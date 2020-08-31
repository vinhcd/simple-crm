<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;
use App\Module\User\Api\Data\GroupInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method integer getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDisplayName()
 * @method $this setDisplayName(string $value)
 * @method integer getPriority()
 * @method $this setPriority(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Group extends AbstractModel implements GroupInterface
{
    /**
     * @var string
     */
    protected $table = 'group';

    /**
     * @var array
     */
    protected $properties = ['name', 'display_name', 'priority', 'description'];

    /**
     * @var Collection
     */
    protected $users;

    /**
     * @return User[]|Collection
     */
    public function getUsers()
    {
        if (!$this->users) {
            $this->users = $this->users()->get();
        }
        return $this->users;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        return $this->getName() == self::SUPER_ADMIN;
    }

    /**
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_group');
    }
}
