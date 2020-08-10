<?php

namespace App\Module\Manager\Models;

use App\Module\Manager\Api\OrganizationRepositoryInterface;
use App\Module\Manager\Models\Data\Organization;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    /**
     * @return Organization
     */
    public function create()
    {
        $organization = new Organization();
        $organization->uuid = $this->generateUuid();

        return $organization;
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return Organization::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getByUuid($uuid)
    {
        return Organization::where(['uuid' => $uuid])->firstOrFail();
    }

    /**
     * @inheritDoc
     */
    public function getBuilder()
    {
        return Organization::query();
    }

    /**
     * @inheritDoc
     */
    public function getAll()
    {
        return Organization::all();
    }

    /**
     * @param Organization $organization
     * @return bool
     * @throws \Exception
     */
    public function save($organization)
    {
        return $organization->save();
    }

    /**
     * @param Organization $organization
     * @return bool|null
     * @throws \Exception
     */
    public function delete($organization)
    {
        return $organization->delete();
    }

    /**
     * @return string
     */
    private function generateUuid()
    {
        return strtoupper(uniqid());
    }
}
