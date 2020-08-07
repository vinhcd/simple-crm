<?php

namespace App;

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
    /**
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
