<?php

use Illuminate\Support\Facades\Route;

Route::get('products', [
    'as' => 'admin.products.index',
    'uses' => 'ProductController@index',
    'middleware' => 'can:admin.products.index',
]);

Route::get('products/create', [
    'as' => 'admin.products.create',
    'uses' => 'ProductController@create',
    'middleware' => 'can:admin.products.create',
]);
Route::get('products/create_banner', [
    'as' => 'admin.products.create_banner',
    'uses' => 'BannerController@create_banner',
    'middleware' => 'can:admin.products.index',
]);

Route::post('products/store_banner', [
    'as' => 'admin.products.store_banner',
    'uses' => 'BannerController@store_banner',
    'middleware' => 'can:admin.products.index',
]);
Route::post('products', [
    'as' => 'admin.products.store',
    'uses' => 'ProductController@store',
    'middleware' => 'can:admin.products.create',
]);

Route::get('products/{id}/edit', [
    'as' => 'admin.products.edit',
    'uses' => 'ProductController@edit',
    'middleware' => 'can:admin.products.edit',
]);

Route::put('products/{id}', [
    'as' => 'admin.products.update',
    'uses' => 'ProductController@update',
    'middleware' => 'can:admin.products.edit',
]);

Route::delete('products/{ids}', [
    'as' => 'admin.products.destroy',
    'uses' => 'ProductController@destroy',
    'middleware' => 'can:admin.products.destroy',
]);
