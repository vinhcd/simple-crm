<?php

namespace App\Module\User\Models\Data;

use App\Models\AbstractModel;
use App\Module\User\Api\Data\PositionInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @method int getId()
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getDescription()
 * @method $this setDescription(string $value)
 */
class Position extends AbstractModel implements PositionInterface
{
    /**
     * @var string
     */
    protected $table = 'position';

    /**
     * @var array
     */
    protected $properties = ['name', 'description'];

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
        return $this->belongsToMany(User::class, 'user_position');
    }
}
