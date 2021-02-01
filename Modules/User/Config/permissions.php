<?php

return [
    'admin.users' => [
        'index' => 'user::permissions.users.index',
        'create' => 'user::permissions.users.create',
        'edit' => 'user::permissions.users.edit',
        'destroy' => 'user::permissions.users.destroy',
    ],
    'admin.roles' => [
        'index' => 'user::permissions.roles.index',
        'create' => 'user::permissions.roles.create',
        'edit' => 'user::permissions.roles.edit',
        'destroy' => 'user::permissions.roles.destroy',
    ],
    'admin.users_plans' => [
        'index' => 'user::permissions.users_plans.index',
        'create' => 'user::permissions.users_plans.create',
        'edit' => 'user::permissions.users_plans.edit',
        'destroy' => 'user::permissions.users_plans.destroy',
    ],
];
