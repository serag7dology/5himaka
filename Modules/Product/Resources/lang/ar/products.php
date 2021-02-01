<?php

return [
    'product' => 'Product',
    'products' => 'Products',
    'table' => [
        'thumbnail' => 'Thumbnail',
        'name' => 'Name',
        'price' => 'Price',
    ],
    'tabs' => [
        'group' => [
            'basic_information' => 'Basic Information',
            'advanced_information' => 'Advanced Information',
        ],
        'general' => 'General',
        'price' => 'Price',
        'inventory' => 'Inventory',
        'images' => 'Images',
        'seo' => 'SEO',
        'related_products' => 'Related Products',
        'up_sells' => 'Up-Sells',
        'cross_sells' => 'Cross-Sells',
        'additional' => 'Additional',
    ],
    'form' => [
        'enable_the_product' => 'Enable the product',
        'used_product' => 'check it if the product is used',
        'price_types' => [
            'fixed' => 'Fixed',
            'percent' => 'Percent',
        ],
        'manage_stock_states' => [
            '0' => 'Don\'t Track Inventory',
            '1' => 'Track Inventory',
        ],
        'stock_availability_states' => [
            '1' => 'In Stock',
            '0' => 'Out of Stock',
        ],
        'base_image' => 'Base Image',
        'additional_images' => 'Additional Images',
        'show_on_home' => 'Show On Home',
        'show_on_banner'=>'Show on Banner',
        
    ],
    'errors'=>[
        'token_not_found'=>'No User With This Token',
        'catid'=>'Category not found',
        'price_changed' =>' sorry price can changed only one time ',
        'no_category'=>"there is no category for this item"
    ]
];
