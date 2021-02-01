<?php

use Illuminate\Support\Facades\Route;

Route::get('plans', [
    'as' => 'admin.plans.index',
    'uses' => 'PlanController@index',
    'middleware' => 'can:admin.plans.index',
]);

Route::get('plans/create', [
    'as' => 'admin.plans.create',
    'uses' => 'PlanController@create',
    'middleware' => 'can:admin.plans.create',
]);

Route::post('plans', [
    'as' => 'admin.plans.store',
    'uses' => 'PlanController@store',
    'middleware' => 'can:admin.plans.create',
]);

Route::get('plans/{id}/edit', [
    'as' => 'admin.plans.edit',
    'uses' => 'PlanController@edit',
    'middleware' => 'can:admin.plans.edit',
]);

Route::put('plans/{id}', [
    'as' => 'admin.plans.update',
    'uses' => 'PlanController@update',
    'middleware' => 'can:admin.plans.edit',
]);

Route::delete('plans/{ids?}', [
    'as' => 'admin.plans.destroy',
    'uses' => 'PlanController@destroy',
    'middleware' => 'can:admin.plans.destroy',
]);

// append
