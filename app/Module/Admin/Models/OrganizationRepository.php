<?php

namespace App\Module\Admin\Models;

use App\Module\Admin\Api\OrganizationRepositoryInterface;
use App\Module\Admin\Models\Data\Database;
use App\Module\Admin\Models\Data\Organization;

class OrganizationRepository implements OrganizationRepositoryInterface
{
    /**
     * @return Organization
     */
    public function create()
    {
        return new Organization();
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
        return Organization::where(['uuid' => $uuid])->first();
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
     * @return Organization|void
     * @throws \Exception
     */
    public function save($organization)
    {
        $uuid = $this->generateUuid();
        $db = new Database();

        $db->dbname = $uuid;
        $organization->uuid = $uuid;

        try {
            $db->save();
            $organization->save();
        } catch (\Exception $e) {
            $db->delete();
            $this->delete($organization);
            throw new \Exception($e->getMessage());
        }
        return $organization;
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
