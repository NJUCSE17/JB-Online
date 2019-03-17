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

        /**
         * Course-related APIs.
         */
        Route::group(['prefix' => '/course', 'as' => 'course'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function () use ($adminMiddleware) {
                    Route::group($adminMiddleware, function () {
                        Route::post('/', 'CourseController@create')->name('create');
                        Route::group(['prefix' => '/{course_id}'], function () {
                            Route::put('/', 'CourseController@update')->name('update');
                            Route::delete('/', 'CourseController@delete')->name('delete');
                        });
                    });
                    Route::get('/', 'CourseController@view')->name('view');
                    Route::get('/{course_id}', 'CourseController@get')->name('get');
                    Route::post('/enroll', 'CourseController@enroll')->name('enroll');
                    Route::post('/quit', 'CourseController@quit')->name('quit');
                });
            });

        /**
         * Assignment-related APIs
         */
        Route::group(['prefix' => '/assignment', 'as' => 'assignment'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function () use ($adminMiddleware) {
                    Route::group($adminMiddleware, function () {
                        Route::post('/', 'AssignmentController@create')->name('create');
                        Route::group(['prefix' => '/{assignment_id}'], function () {
                            Route::put('/', 'AssignmentController@update')->name('update');
                            Route::delete('/', 'AssignmentController@delete')->name('delete');
                        });
                    });
                });
                Route::get('/', 'AssignmentController@view')->name('view');
                Route::get('/{assignment_id}', 'AssignmentController@get')->name('get');
                Route::post('/finish', 'AssignmentController@finish')->name('finish');
                Route::post('/reset', 'AssignmentController@reset')->name('reset');
            });

        /**
         * Personal-assignment-related APIs
         */
        Route::group(['prefix' => '/personal', 'as' => 'personal'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function () use ($adminMiddleware) {
                    Route::group($adminMiddleware, function () {
                        Route::post('/', 'PersonalAssignmentController@create')->name('create');
                        Route::group(['prefix' => '/{personal_assignment_id}'], function () {
                            Route::put('/', 'PersonalAssignmentController@update')->name('update');
                            Route::delete('/', 'PersonalAssignmentController@delete')->name('delete');
                        });
                    });
                });
                Route::get('/', 'PersonalAssignmentController@view')->name('view');
                Route::get('/{personal_assignment_id}', 'PersonalAssignmentController@get')->name('get');
                Route::post('/finish', 'PersonalAssignmentController@finish')->name('finish');
                Route::post('/reset', 'PersonalAssignmentController@reset')->name('reset');
            });

        /**
         * Problem-related APIs
         */
        Route::group(['prefix' => '/problem', 'as' => 'problem'],
            function () use ($authMiddleware, $adminMiddleware) {
                Route::group($authMiddleware, function () use ($adminMiddleware) {
                    Route::group($adminMiddleware, function () {
                        Route::post('/', 'ProblemController@create')->name('create');
                        Route::group(['prefix' => '/{problem_id}'], function () {
                            Route::put('/', 'ProblemController@update')->name('update');
                            Route::delete('/', 'ProblemController@delete')->name('delete');
                        });
                    });
                });
                Route::get('/', 'ProblemController@view')->name('view');
                Route::get('/{problem_id}', 'ProblemController@get')->name('get');
            });
});
