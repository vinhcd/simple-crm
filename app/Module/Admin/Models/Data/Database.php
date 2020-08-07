<?php

namespace App\Module\Admin\Models\Data;

use App\AbstractModel;
use App\Module\Admin\Api\Data\DatabaseInterface;

class Database extends AbstractModel implements DatabaseInterface
{
    /**
     * @var string
     */
    protected $table = 'organization_db';

    /**
     * @inheritDoc
     */
    public function getOrganizationDBConnection()
    {
        return [
            'driver' => 'mysql',
            'host' => $this->host ?: env('DB_HOST', '127.0.0.1'),
            'port' => $this->port ?: env('DB_PORT', '3306'),
            'database' => $this->dbname,
            'username' => $this->username ?: env('DB_USERNAME', 'root'),
            'password' => $this->password ?: env('DB_PASSWORD', ''),
            'unix_socket' => env('DB_SOCKET', ''),
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ];
    }

    /**
     * @inheritDoc
     */
    public function getById($id)
    {
       return self::find($id);
    }
}
