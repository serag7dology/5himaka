<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//not loged apis
Route::group(['middleware' => ['api','checkPassword','changeLanguage']], function () {   
        Route::group(['prefix' => 'user'],function (){
            
        });
});

//loged user apis
Route::group(['middleware' => ['api','checkPassword','checkUserToken:api','changeLanguage']], function () {
    Route::group(['prefix' => 'user'],function (){
    Route::post('store/order', 'OrderController@order');
    Route::post('order/details', 'OrderController@details');
    Route::post('pre/order', 'OrderController@pre_order');
    Route::post('check/commission/amount', 'OrderController@checkCommissionAmount');
    Route::post('pay/commission', 'OrderController@payWithCommission');
    

    });
});
