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
        Route::post('login', 'AuthController@login');
        Route::post('register', 'AuthController@register');
        Route::post('send-code'             , 'Auth\ForgetPasswordController@sendOtp');
        Route::post('resend-code'           , 'Auth\ForgetPasswordController@sendOtp');
        Route::post('code-check'            , 'Auth\ForgetPasswordController@checkOtp');
        Route::post('reset-password'         , 'Auth\ResetPasswordController@resetPassword');
    });
    Route::get('pre_register', 'AuthController@pre_register');
    Route::post('pre_register_page1', 'AuthController@pre_register_page1');
    Route::post('pre_register_page2', 'AuthController@pre_register_page2');
    Route::post('pre_register_page3', 'AuthController@pre_register_page3');
   

});


//loged user apis
Route::group(['middleware' => ['api','checkPassword','checkUserToken:api','changeLanguage']], function () {
    Route::group(['prefix' => 'user'],function (){
    Route::post('logout', 'AuthController@logout');
    Route::post('wishlist', 'UserController@wishlist');
    Route::post('favProductOrService', 'UserController@favProductOrService');
    Route::post('getUserProfileDetails', 'UserController@getUserProfileDetails');
    Route::post('editUserProfileDetails', 'UserController@editUserProfileDetails');
    Route::post('editUserAddress', 'UserController@editUserAddress');
    Route::post('getMethodsOfCashOut', 'UserController@getMethodsOfCashOut');
    Route::post('changeMethodOfCashOut', 'UserController@changeMethodOfCashOut');
    Route::post('orders', 'UserController@orders');
    Route::post('cashback', 'UserController@cashback');
    Route::post('transition', 'UserController@transition');
    Route::post('commission/wallet', 'UserController@commission_wallet');
    Route::post('convert/points', 'UserController@convert_points');

    Route::post('reward', 'UserController@reward');
    Route::post('earning', 'UserController@earning');
    Route::post('plan/pre_upgrade', 'UserController@pre_upgrade');
    Route::post('plan/upgrade', 'UserController@upgrade');
    Route::post('pre_person/wallet/cashout', 'UserController@pre_person_wallet_cashout');
    Route::post('person/wallet/cashout', 'UserController@person_wallet_cashout');
    Route::post('cashout/requests', 'UserController@cashout_requests');
    Route::post('complaint/store', 'ComplaintController@store');
    Route::post('get/orders', 'ComplaintController@getUserOrders');
    Route::post('get/user-complaints', 'ComplaintController@getUserComplaint');
    Route::post('change/paid', 'UserController@paid');

    });
});


Route::group(['middleware' => ['api','checkPassword','changeLanguage']], function () {
    Route::group(['prefix' => 'user'],function (){
    Route::post('accept/url', 'PaymentController@card');
    Route::post('fawry/code', 'PaymentController@getPaymentUrl');
    Route::post('kiosk', 'PaymentController@kiosk');

    

    

    });
});
