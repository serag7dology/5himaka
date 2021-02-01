<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {
    
    Route::post('cart/coupon', 'CartCouponController@store')->name('cart.coupon.store');
    Route::delete('cart/coupon', 'CartCouponController@destroy')->name('cart.coupon.destroy');
});
