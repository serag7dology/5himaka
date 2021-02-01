<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('categories', 'CategoryController@index')->name('categories.index');
    
    Route::get('categories/{category}/products', 'CategoryProductController@index')->name('categories.products.index');
});
