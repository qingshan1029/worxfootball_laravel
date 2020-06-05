<?php

Route::get('/home', function () {
    if (session('status')) {
        return redirect()->route('admin.matches.index')->with('status', session('status'));
    }

    return redirect()->route('admin.matches.index');
});

Route::get('/', 'HomeController@index')->name('home');
//Route::get('shop/{shop}', 'HomeController@show')->name('shop');

Auth::routes();

Route::group(['prefix' => 'admin', 'as' => 'admin.', 'namespace' => 'Admin', 'middleware' => ['auth']], function () {
    Route::get('/', 'HomeController@index')->name('home');
    // Permissions
    Route::delete('permissions/destroy', 'PermissionsController@massDestroy')->name('permissions.massDestroy');
    Route::resource('permissions', 'PermissionsController');

    // Roles
    Route::delete('roles/destroy', 'RolesController@massDestroy')->name('roles.massDestroy');
    Route::resource('roles', 'RolesController');

    // Users
    Route::delete('users/destroy', 'UsersController@massDestroy')->name('users.massDestroy');
    Route::resource('users', 'UsersController');

    // Players
    Route::delete('players/destroy', 'PlayersController@massDestroy')->name('players.massDestroy');
    Route::resource('players', 'PlayersController');

//    // Categories
//    Route::delete('categories/destroy', 'CategoriesController@massDestroy')->name('categories.massDestroy');
//    Route::resource('categories', 'CategoriesController');
//
//    // Shops
//    Route::delete('shops/destroy', 'ShopsController@massDestroy')->name('shops.massDestroy');
//    Route::post('shops/media', 'ShopsController@storeMedia')->name('shops.storeMedia');
//    Route::resource('shops', 'ShopsController');

    // Matches
    Route::delete('matches/destroy', 'MatchesController@massDestroy')->name('matches.massDestroy');
    Route::resource('matches', 'MatchesController');

    // Bookings
    Route::delete('bookings/destroy', 'BookingsController@massDestroy')->name('bookings.massDestroy');
    Route::resource('bookings', 'BookingsController');

    // Activities
    Route::delete('activities/destroy', 'ActivitiesController@massDestroy')->name('activities.massDestroy');
    Route::resource('activities', 'ActivitiesController');

    // Transactions
    Route::delete('transactions/destroy', 'TransactionsController@massDestroy')->name('transactions.massDestroy');
    Route::resource('transactions', 'TransactionsController');

    // Payment
    Route::resource('payments', 'PaymentsController');
});



