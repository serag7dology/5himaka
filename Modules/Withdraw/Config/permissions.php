<?php

return [
    'admin.withdraws' => [
        'index' => 'withdraw::permissions.withdraw_methods.index',
        'create' => 'withdraw::permissions.withdraw_methods.create',
        'edit' => 'withdraw::permissions.withdraw_methods.edit',
        'destroy' => 'withdraw::permissions.withdraw_methods.destroy',
    ],
    'admin.withdraw_requests' => [
        'index' => 'withdraw::permissions.withdraw_requests.index',
        'create' => 'withdraw::permissions.withdraw_requests.create',
        'edit' => 'withdraw::permissions.withdraw_requests.edit',
        'destroy' => 'withdraw::permissions.withdraw_requests.destroy',
    ],
];
