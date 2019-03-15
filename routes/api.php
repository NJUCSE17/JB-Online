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

// TODO: IMPLEMENT API MIDDLEWARES!!!
$authMiddleware  = [];
$adminMiddleware = [];

Route::group(['as' => 'api', 'namespace' => 'API', 'middleware' => 'throttle:20'],
    function () use ($authMiddleware, $adminMiddleware) {
        /**
         * User-related APIs.
         */
        Route::group(['prefix' => '/user', 'as' => 'user'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function() use ($adminMiddleware) {
                    Route::group($adminMiddleware, function () {
                        Route::post('/', 'UserController@create')->name('create');
                        Route::group(['prefix' => '/{user_id}'], function () {
                            Route::delete('/', 'UserController@delete')->name('delete');
                            Route::post('/activate', 'UserController@activate')->name('activate');
                            Route::post('/deactivate', 'UserController@deactivate')->name('deactivate');
                        });
                    });
                    Route::get('/{user_id?}', 'UserController@get')->name('get');
                    Route::put('/', 'UserController@update')->name('update');
                });
        });
});
