<?php

namespace App\Module\Manager\Api\Data;

/**
 * @property integer id
 * @property string name
 * @property string uuid
 * @property string phone_number
 * @property string tax_number
 * @property string address
 * @property string register_date
 * @property integer plan_id
 * @property integer database_id
 * @property string comment
 */
interface OrganizationInterface
{
    const RESOURCE_ID = 'organization';
}
