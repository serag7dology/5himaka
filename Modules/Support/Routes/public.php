<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth'], function () {
    Route::get('countries/{code}/states', 'CountryStateController@index')->name('countries.states.index');
    
});