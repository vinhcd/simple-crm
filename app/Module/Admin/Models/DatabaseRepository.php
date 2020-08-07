<?php

namespace App\Module\Admin\Models;

use App\Module\Admin\Api\DatabaseRepositoryInterface;
use App\Module\Admin\Models\Data\Database;

class DatabaseRepository implements DatabaseRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getById($id)
    {
        return Database::findOrFail($id);
    }

    /**
     * @inheritDoc
     */
    public function getByDbName($dbName)
    {
        return Database::where(['dbname' => $dbName])->firstOrFail();
    }
}
