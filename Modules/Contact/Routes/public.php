<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('contact', 'ContactController@create')->name('contact.create');
    Route::post('contact', 'ContactController@store')->name('contact.store');
});
