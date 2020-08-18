<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;
use App\Module\User\Api\Data\DepartmentInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDisplayName()
 * @method $this setDisplayName(string $value)
 * @method int getParentId()
 * @method $this setParentId(int $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Department extends AbstractModel implements DepartmentInterface
{
    /**
     * @var string
     */
    protected $table = 'department';

    /**
     * @var array
     */
    protected $properties = ['name', 'display_name', 'parent_id', 'description'];

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
     * @return BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'user_department');
    }
}
