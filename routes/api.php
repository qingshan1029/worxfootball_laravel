<?php

//Route::group(['prefix' => 'v1', 'as' => 'api.', 'namespace' => 'Api\V1\Admin', 'middleware' => ['auth:api']], function () {
//    // Permissions
//    Route::apiResource('permissions', 'PermissionsApiController');
//
//    // Roles
//    Route::apiResource('roles', 'RolesApiController');
//
//    // Users
//    Route::apiResource('users', 'UsersApiController');
//
//    // Categories
//    Route::apiResource('categories', 'CategoriesApiController');
//
//    // Shops
//    Route::post('shops/media', 'ShopsApiController@storeMedia')->name('shops.storeMedia');
//    Route::apiResource('shops', 'ShopsApiController');
//});

Route::post('login', 'Api\UserAPIController@login');
Route::post('register', 'Api\UserAPIController@register');
Route::post('users', 'Api\UserAPIController@users');

Route::post('player/login', 'Api\PlayerAPIController@login');
Route::post('player/register', 'Api\PlayerAPIController@register');
Route::post('player/players', 'Api\PlayerAPIController@players');
Route::post('player/transactions', 'Api\PlayerAPIController@getTransactions');

Route::post('matches', 'Api\MatchAPIController@getMatches');
//Route::post('reserve', 'Api\BookingAPIController@createReservations');

Route::post('pay', 'Api\PaymentAPIController@pay');


//Route::group(['middleware' => 'auth:api'], function() {
//    Route::post('users', 'Api\UserAPIController@users');
//});
