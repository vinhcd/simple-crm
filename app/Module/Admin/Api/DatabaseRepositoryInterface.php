<?php


namespace App\Module\Admin\Api;

use App\Module\Admin\Api\Data\DatabaseInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;

interface DatabaseRepositoryInterface
{
    /**
     * @param integer $id
     * @return DatabaseInterface
     * @throws ModelNotFoundException
     */
    public function getById($id);

    /**
     * @param string $dbName
     * @return DatabaseInterface
     * @throws ModelNotFoundException
     */
    public function getByDbName($dbName);
}
