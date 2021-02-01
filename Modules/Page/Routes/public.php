<?php

use Illuminate\Support\Facades\Route;
Route::get('/pay', 'HomeController@pay')->name('pay');
Route::get('/paysuccess', function(){
    return view('public.home.pay_success');
});
Route::get('/payfaild', function(){
    return view('public.home.pay_faild');
});
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', 'HomeController@index')->name('home');
});
