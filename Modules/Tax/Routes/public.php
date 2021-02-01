<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::post('cart/taxes', 'CartTaxController@store')->name('cart.taxes.store');
    
});