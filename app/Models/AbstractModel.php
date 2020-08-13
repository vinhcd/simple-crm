<?php

namespace App\Models;

use App\Models\Traits\AccessorMutatorGenerator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static Model find($id)
 * @method static Model findOrFail($id)
 * @method static Model firstOrCreate(array $data)
 * @method static Builder where($mixed)
 */
abstract class AbstractModel extends Model
{
    use AccessorMutatorGenerator;

    /**
     * The attributes which can be generated for get/set automatically
     *
     * @var array
     */
    protected $properties = [];

    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
