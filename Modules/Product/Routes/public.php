<?php

use Illuminate\Support\Facades\Route;
Route::group(['middleware' => 'auth'], function () {

Route::get('products', 'ProductController@index')->name('products.index');
Route::get('products/{slug}', 'ProductController@show')->name('products.show');
Route::get('chat', 'FirebaseController@index')->name('chat');
Route::middleware('auth')->group(function () {
Route::get('products/chat/{slug}', 'ProductController@chat')->name('products.chat');
Route::post('products/chat/{slug}', 'ProductController@chat')->name('products.chat');
Route::get('createchat', 'ProductController@createchat')->name('products.createchat');
Route::post('accept_price', 'ProductController@acceptPrice')->name('products.accept_price');
});
});
