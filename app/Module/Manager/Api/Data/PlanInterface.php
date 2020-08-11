<?php

namespace App\Module\Manager\Api\Data;

/**
 * @property integer id
 * @property string name
 * @property float price
 * @property integer max_staff
 * @property integer trial_days
 * @property string description
 */
interface PlanInterface
{
    const RESOURCE_ID = 'plan';
}
