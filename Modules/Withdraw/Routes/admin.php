<?php

use Illuminate\Support\Facades\Route;

Route::get('withdraws', [
    'as' => 'admin.withdraws.index',
    'uses' => 'WithdrawController@index',
    'middleware' => 'can:admin.withdraws.index',
]);

Route::get('withdraws', [
    'as' => 'admin.withdraws_ways.index',
    'uses' => 'WithdrawController@index',
    'middleware' => 'can:admin.withdraws.index',
]);

Route::get('withdraws/create', [
    'as' => 'admin.withdraws_ways.create',
    'uses' => 'WithdrawController@create',
    'middleware' => 'can:admin.withdraws.create',
]);
Route::post('withdraws', [
    
    'as' => 'admin.withdraws_ways.store',
    'uses' => 'WithdrawController@store',
    'middleware' => 'can:admin.withdraws.create',
]);
Route::get('withdraws/{id}/edit', [
    'as' => 'admin.withdraws_ways.edit',
    'uses' => 'WithdrawController@edit',
    'middleware' => 'can:admin.withdraws.edit',

]);

Route::put('withdraws/{id}/edit', [
    'as' => 'admin.withdraws_ways.update',
    'uses' => 'WithdrawController@update',
    'middleware' => 'can:admin.withdraws.edit',
]);

Route::delete('withdraws/{ids?}', [
    'as' => 'admin.withdraws_ways.destroy',
    'uses' => 'WithdrawController@destroy',
    'middleware' => 'can:admin.withdraws.destroy',
]);



//requests
Route::get('withdraws/requests', [
    'as' => 'admin.withdraw_requests.index',
    'uses' => 'WithdrawRequestController@index',
    'middleware' => 'can:admin.withdraw_requests.index',
]);



Route::get('withdraws/requests/create', [
    'as' => 'admin.withdraw_requests.create',
    'uses' => 'WithdrawRequestController@create',
    'middleware' => 'can:admin.withdraw_requests.create',
]);
Route::post('withdraws/requests', [
    
    'as' => 'admin.withdraw_requests.store',
    'uses' => 'WithdrawRequestController@store',
    'middleware' => 'can:admin.withdraw_requests.create',
]);
Route::get('withdraws/requests/{id}/edit', [
    'as' => 'admin.withdraw_requests.edit',
    'uses' => 'WithdrawRequestController@edit',
    'middleware' => 'can:admin.withdraw_requests.edit',

]);

Route::put('withdraws/requests/{id}/edit', [
    'as' => 'admin.withdraw_requests.update',
    'uses' => 'WithdrawRequestController@update',
    'middleware' => 'can:admin.withdraw_requests.edit',
]);

Route::delete('withdraws/requests/{ids?}', [
    'as' => 'admin.withdraw_requests.destroy',
    'uses' => 'WithdrawRequestController@destroy',
    'middleware' => 'can:admin.withdraw_requests.destroy',
]);