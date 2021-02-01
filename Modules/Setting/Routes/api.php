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

    Route::get('customer_support', 'SettingController@customer_support');

});


//loged user apis
Route::group(['middleware' => ['api','checkPassword','checkUserToken:api','changeLanguage']], function () {

    

});
