<?php

use Illuminate\Support\Facades\Route;
Route::get('/paycard/{amount}','PaymentController@card')->name('paycard');
Route::get('/paykiosk/{amount}','PaymentController@kiosk')->name('paykiosk');
Route::get('/payfawry/{amount}', 'PaymentController@fawry')->name('payfawry');
Route::group(['middleware' => 'auth'], function () {
    
    Route::get('checkout', 'CheckoutController@create')->name('checkout.create');
    Route::post('checkout', 'CheckoutController@store')->name('checkout.store');
    
    Route::get('checkout/{orderId}/complete', 'CheckoutCompleteController@store')->name('checkout.complete.store');
    Route::get('checkout/complete', 'CheckoutCompleteController@show')->name('checkout.complete.show');
    
    Route::get('checkout/{orderId}/payment-canceled', 'PaymentCanceledController@store')->name('checkout.payment_canceled.store');
    Route::get('/card/{amount}','PaymentController@card')->name('card');
    Route::get('/kiosk/{amount}','PaymentController@kiosk')->name('kiosk');
    Route::get('/fawry/{amount}', 'PaymentController@fawry')->name('fawry');
    Route::get('/wallet/{amount}/{wallet_id}', 'PaymentController@payWithCommission')->name('wallet');
});
