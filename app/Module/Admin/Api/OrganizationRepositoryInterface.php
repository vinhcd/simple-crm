<?php

namespace App\Module\Admin\Api;

use App\Module\Admin\Api\Data\OrganizationInterface;
use Illuminate\Database\Eloquent\Collection;

interface OrganizationRepositoryInterface
{
    /**
     * @return OrganizationInterface
     */
    public function create();

    /**
     * @return Collection
     */
    public function getAll();

    /**
     * @param OrganizationInterface $organization
     * @return OrganizationInterface
     */
    public function save($organization);
}
