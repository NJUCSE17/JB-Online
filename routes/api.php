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

$authMiddleware  = ['middleware' => 'auth:api'];
$adminMiddleware = []; // TODO: IMPLEMENT PREMISSIONS!!

Route::group(['as' => 'api', 'namespace' => 'API', 'middleware' => 'throttle:20'],
    function () use ($authMiddleware, $adminMiddleware) {
        /**
         * User-related APIs.
         */
        Route::group(['prefix' => '/user/{user_id}', 'as' => 'user'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function() {
                    Route::get('/', 'UserController@get')->name('get');
                    Route::put('/', 'UserController@update')->name('update');
                });
                Route::group($adminMiddleware, function () {
                    Route::post('/', 'UserController@create')->name('create');
                    Route::delete('/', 'UserController@delete')->name('delete');
                });
        });
});
