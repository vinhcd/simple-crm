<?php

namespace App\Module\User\Models\Data;

use App\Models\Traits\AccessorMutatorGenerator;
use App\Module\User\Api\Data\UserInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * @method string getName()
 * @method string setName(string $value)
 * @method string getEmail()
 * @method string setEmail(string $value)
 * @method string getPassword()
 * @method string setPassword(string $value)
 * @method string getFirstName()
 * @method string setFirstName(string $value)
 * @method string getLastName()
 * @method string setLastName(string $value)
 * @method string getDescription()
 * @method string setDescription(string $value)
 *
 * @method static Model find($id)
 * @method static Model findOrFail($id)
 * @method static Model firstOrCreate(array $data)
 * @method static Builder where($mixed)
 */
class User extends Authenticatable implements UserInterface
{
    use Notifiable, AccessorMutatorGenerator;

    /**
     * The attributes which can be generated for get/set automatically
     *
     * @var string[]
     */
    protected $properties = ['name', 'email', 'password', 'first_name', 'last_name', 'description'];

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

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
}
