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
    public function getConnection()
    {
        return [
            'driver' => 'mysql',
            'host' => $this->getHost() ?: env('DB_HOST', '127.0.0.1'),
            'port' => $this->getPort() ?: env('DB_PORT', '3306'),
            'database' => $this->getName(),
            'username' => $this->getUsername() ?: env('DB_USERNAME', 'root'),
            'password' => $this->getPassword() ?: env('DB_PASSWORD', ''),
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

    /**
     * @inheritDoc
     */
    public function getName()
    {
        return $this->dbname;
    }

    /**
     * @inheritDoc
     */
    public function setName($name)
    {
        $this->dbname = $name;
    }

    /**
     * @inheritDoc
     */
    public function getHost()
    {
        return $this->host;
    }

    /**
     * @inheritDoc
     */
    public function setHost($host)
    {
        $this->host = $host;
    }

    /**
     * @inheritDoc
     */
    public function getPort()
    {
        return $this->port;
    }

    /**
     * @inheritDoc
     */
    public function setPort($port)
    {
        $this->port = $port;
    }

    /**
     * @inheritDoc
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @inheritDoc
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @inheritDoc
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @inheritDoc
     */
    public function setPassword($password)
    {
        $this->password = $password;
    }

    /**
     * @inheritDoc
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @inheritDoc
     */
    public function setComment($text)
    {
        $this->comment = $text;
    }
}
