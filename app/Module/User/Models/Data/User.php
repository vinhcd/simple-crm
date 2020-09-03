<?php

namespace App\Module\User\Models\Data;

use App\Models\Traits\AccessorMutatorGenerator;
use App\Module\User\Api\Data\UserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method string getName()
 * @method $this setName(string $value)
 * @method string getEmail()
 * @method $this setEmail(string $value)
 * @method string getPassword()
 * @method $this setPassword(string $value)
 * @method string getFirstName()
 * @method $this setFirstName(string $value)
 * @method string getLastName()
 * @method $this setLastName(string $value)
 * @method int getDeleted()
 * @method $this setDeleted(int $value)
 *
 * @method static Model find($id)
 * @method static Model findOrFail($id)
 * @method static Model firstOrCreate(array $data)
 * @method static Builder where($column, $operator = null, $value = null, $boolean = 'and')
 */
class User extends Authenticatable implements UserInterface
{
    use Notifiable, AccessorMutatorGenerator;

    /**
     * The attributes which can be generated for get/set automatically
     *
     * @var string[]
     */
    protected $properties = ['name', 'email', 'password', 'first_name', 'last_name', 'description', 'deleted'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'first_name', 'last_name', 'description',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected $info;

    /**
     * @var Collection
     */
    protected $groups;

    /**
     * @var Collection
     */
    protected $positions;

    /**
     * @var Collection
     */
    protected $departments;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFullName()
    {
        return (empty($this->getFirstName()) && empty($this->getLastName()))
            ? $this->getName()
            : $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @return Group[] | Collection
     */
    public function getGroups()
    {
        if (!$this->groups) {
            $this->groups = $this->groups()->get();
        }
        return $this->groups;
    }

    /**
     * @return Position[] | Collection
     */
    public function getPositions()
    {
        if (!$this->positions) {
            $this->positions = $this->positions()->get();
        }
        return $this->positions;
    }

    /**
     * @return Department[] | Collection
     */
    public function getDepartments()
    {
        if (!$this->departments) {
            $this->departments = $this->departments()->get();
        }
        return $this->departments;
    }

    /**
     * @return UserInfo
     */
    public function getInfo()
    {
        if (!$this->info) {
            $this->info = $this->info()->first();
            if (!$this->info) $this->info = new UserInfo();
        }
        return $this->info;
    }

    /**
     * @return bool
     */
    public function isSuperAdmin()
    {
        foreach ($this->getGroups() as $group) {
            if ($group->getName() == Group::SUPER_ADMIN) return true;
        }
        return false;
    }

    /**
     * @return HasOne
     */
    public function info()
    {
        return $this->hasOne(UserInfo::class);
    }

    /**
     * @return BelongsToMany
     */
    public function groups()
    {
        return $this->belongsToMany(Group::class, 'user_group');
    }

    /**
     * @return BelongsToMany
     */
    public function positions()
    {
        return $this->belongsToMany(Position::class, 'user_position');
    }

    /**
     * @return BelongsToMany
     */
    public function departments()
    {
        return $this->belongsToMany(Department::class, 'user_department');
    }
}
