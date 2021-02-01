<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('tags/{tag}/products', 'TagProductController@index')->name('tags.products.index');
    
});