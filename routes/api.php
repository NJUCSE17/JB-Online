<?php

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

Route::group(['as' => 'api', 'namespace' => 'API', 'middleware' => 'throttle:20'], function () {
        /**
         * User-related APIs.
         */
    Route::group(['prefix' => '/user', 'as' => 'user'], function () {
        Route::post('/', 'UserController@create')->name('create');
        Route::get('/', 'UserController@read')->name('read');
        Route::put('/', 'UserController@update')->name('update');
        Route::delete('/', 'UserController@delete')->name('delete');
        Route::post('/activate', 'UserController@activate')->name('activate');
        Route::post('/deactivate', 'UserController@deactivate')->name('deactivate');
        });

        /**
         * Course-related APIs.
         */
    Route::group(['prefix' => '/course', 'as' => 'course'], function () {
        Route::post('/', 'CourseController@create')->name('create');
        Route::get('/', 'CourseController@read')->name('read');
        Route::put('/', 'CourseController@update')->name('update');
        Route::delete('/', 'CourseController@delete')->name('delete');
        Route::post('/enroll', 'CourseController@enroll')->name('enroll');
        Route::post('/quit', 'CourseController@quit')->name('quit');
    });

        /**
         * Assignment-related APIs
         */
        Route::group(['prefix' => '/assignment', 'as' => 'assignment'], function () {
            Route::post('/', 'AssignmentController@create')->name('create');
            Route::get('/', 'AssignmentController@read')->name('read');
            Route::put('/', 'AssignmentController@update')->name('update');
            Route::delete('/', 'AssignmentController@delete')->name('delete');
            Route::post('/finish', 'AssignmentController@finish')->name('finish');
            Route::post('/reset', 'AssignmentController@reset')->name('reset');
        });

        /**
         * Personal-assignment-related APIs
         */
    Route::group(['prefix' => '/personal', 'as' => 'personal'], function () {
        Route::post('/', 'PersonalAssignmentController@create')->name('create');
        Route::get('/', 'PersonalAssignmentController@read')->name('read');
        Route::put('/', 'PersonalAssignmentController@update')->name('update');
        Route::delete('/', 'PersonalAssignmentController@delete')->name('delete');
        Route::post('/finish', 'PersonalAssignmentController@finish')->name('finish');
        Route::post('/reset', 'PersonalAssignmentController@reset')->name('reset');
    });

        /**
         * Problem-related APIs
         */
    Route::group(['prefix' => '/problem', 'as' => 'problem'], function () {
        Route::post('/', 'ProblemController@create')->name('create');
        Route::get('/', 'ProblemController@read')->name('read');
        Route::put('/', 'ProblemController@update')->name('update');
        Route::delete('/', 'ProblemController@delete')->name('delete');
    });
});
