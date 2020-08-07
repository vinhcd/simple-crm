<?php

namespace App\Module\Admin\Api\Data;

/**
 * @property integer id
 * @property string dbname
 * @property string host
 * @property integer port
 * @property string username
 * @property string password
 * @property string comment
 */
interface DatabaseInterface
{
    /**
     * @return array
     */
    public function getOrganizationDBConnection();
}
