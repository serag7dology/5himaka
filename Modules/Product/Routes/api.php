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
Route::group(['middleware' => ['api','changeLanguage']], function () {   

    Route::post('home', 'ProductController@home');
});


//loged user apis
Route::post('save-token', 'ProductController@saveToken');
Route::group(['middleware' => ['api','checkUserToken:api','changeLanguage']], function () {
    
    Route::post('getBannerProduct', 'ProductController@getBannerProduct');
    Route::post('products-savedInCard', 'ProductController@productsSavedInCard');
    Route::post('products-saled', 'ProductController@productSold');
    Route::post('products-purchased', 'ProductController@productsPurchased');
    Route::post('add_product_service', 'ProductController@add');
    Route::post('serach/ProductsOrService', 'ProductController@search');
    Route::post('prepFilter', 'ProductController@prepFilter');
    Route::post('filter', 'ProductController@filter');
    Route::post('ProductOrServiceDetails', 'ProductController@ProductOrServiceDetails');
    Route::post('addReview', 'ProductController@addReview');
    Route::post('new-price', 'ProductController@NewPrice');
    Route::post('check', 'ProductController@check');

});
