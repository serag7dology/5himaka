<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('products/{productId}/reviews', 'ProductReviewController@index')->name('products.reviews.index');
    Route::post('products/{productId}/reviews', 'ProductReviewController@store')->name('products.reviews.store');
});
