<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('current-currency/{code}', 'CurrentCurrencyController@store')->name('current_currency.store');
    
});