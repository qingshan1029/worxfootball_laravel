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
Route::post('player/info', 'Api\PlayerAPIController@info');
Route::post('player/update', 'Api\PlayerAPIController@update');
Route::post('player/delete', 'Api\PlayerAPIController@delete');


Route::post('matches/get', 'Api\MatchAPIController@get');

Route::post('booking/reserve', 'Api\BookingAPIController@createReservations');

Route::post('transactions/get', 'Api\TransactionAPIController@get');

Route::post('payment/pay', 'Api\PaymentAPIController@pay');

Route::post('activity/getAll', 'Api\ActivityAPIController@getAll');
Route::post('activity/setFeedback', 'Api\ActivityAPIController@setFeedback');



//Route::group(['middleware' => 'auth:api'], function() {
//    Route::post('users', 'Api\UserAPIController@users');
//});
