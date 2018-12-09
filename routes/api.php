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

Route::group(['namespace' => 'API'], function () {
    Route::post('app', 'UserController@app');
    Route::post('login', 'UserController@login');
    Route::group(['middleware' => 'auth:api'], function () {
        Route::post('logout', 'UserController@logout');

        Route::post('notice', 'UserController@getNotice');
        Route::post('assignments', 'UserController@getAssignments');

        Route::group(['prefix' => 'assignment/{assignment}'], function () {
            Route::post('finish', 'UserController@finishAssignment');
            Route::post('reset', 'UserController@resetAssignment');
        });

        //Route::group(['middleware' => 'admin', 'prefix' => 'admin/'], function () {
        //    Route::group(['prefix' => 'assignment'], function () {
        //        Route::post('create', 'AdminController@createAssignment');
        //        Route::post('edit', 'AdminController@editAssignment');
        //    });
        //});
    });
});
