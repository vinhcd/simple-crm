<?php

namespace App\Module\Manager\Api;

use App\Module\Manager\Api\Data\OrganizationInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface OrganizationRepositoryInterface
{
    /**
     * @return OrganizationInterface
     */
    public function create();

    /**
     * @param integer $id
     * @return OrganizationInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param string $uuid
     * @return OrganizationInterface
     * @throws ModelNotFoundException
     */
    public function getByUuid($uuid);

    /**
     * @return Builder
     */
    public function getBuilder();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param OrganizationInterface $organization
     * @return OrganizationInterface
     * @throws \Exception
     */
    public function save($organization);

    /**
     * @param OrganizationInterface $organization
     * @return bool
     * @throws \Exception
     */
    public function delete($organization);
}
