<?php

namespace App\Module\User\Models;

use App\Module\User\Api\PositionRepositoryInterface;
use App\Module\User\Models\Data\Position;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class PositionRepository implements PositionRepositoryInterface
{
    /**
     * @return Position
     */
    public function create()
    {
        return new Position();
    }

    /**
     * @param int $id
     * @return Position
     * @throws ModelNotFoundException
     */
    public function getById($id)
    {
        return Position::findOrFail($id);
    }

    /**
     * @return Builder
     */
    public function getBuilder()
    {
        return Position::query();
    }

    /**
     * @return Position[] | Collection
     */
    public function getAll()
    {
        return Position::all();
    }

    /**
     * @param Position $position
     * @return bool
     * @throws \Exception
     */
    public function save($position)
    {
        return $position->save();
    }

    /**
     * @param Position $position
     * @return bool
     * @throws \Exception
     */
    public function delete($position)
    {
        return $position->delete();
    }
}
