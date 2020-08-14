<?php

return [
    'acl' => [
        \App\Module\Acl\Api\Data\RoleInterface::class => \App\Module\Acl\Models\Data\Role::class,
        \App\Module\Acl\Api\Data\RoleItemInterface::class => \App\Module\Acl\Models\Data\RoleItem::class,
        \App\Module\Acl\Api\Data\RolePermissionInterface::class => \App\Module\Acl\Models\Data\RolePermission::class,

        \App\Module\Acl\Api\AclCheckerInterface::class => \App\Module\Acl\Models\AclChecker::class,
        \App\Module\Acl\Api\RoleRepositoryInterface::class => \App\Module\Acl\Models\RoleRepository::class,
    ]
];
