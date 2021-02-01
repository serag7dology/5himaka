<?php

return [
    'admin.orders' => [
        'index' => 'order::permissions.index',
        'show' => 'order::permissions.show',
        'edit' => 'order::permissions.edit',
        'customers.products.plus' => 'order::permissions.plus_100_product',
    ],
];
