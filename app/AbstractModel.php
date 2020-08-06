<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

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
