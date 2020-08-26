<?php

namespace App\Module\User\Api;

use App\Module\User\Api\Data\PositionInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface PositionRepositoryInterface
{
    /**
     * @return PositionInterface
     */
    public function create();

    /**
     * @param int $id
     * @return PositionInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return PositionInterface[] | Collection
     */
    public function getAll();

    /**
     * @param PositionInterface $position
     * @return bool
     * @throws \Exception
     */
    public function save($position);

    /**
     * @param PositionInterface $position
     * @return bool
     * @throws \Exception
     */
    public function delete($position);
}
