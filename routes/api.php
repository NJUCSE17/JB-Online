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

Route::group(
    [
        'as'         => 'api.',
        'namespace'  => 'API',
        'middleware' => ['auth:api', 'verified', 'activated'],
    ],
    function () {
        Route::apiResources([
            'user'               => 'UserController',
            'course'             => 'CourseController',
            'assignment'         => 'AssignmentController',
            'personalAssignment' => 'PersonalAssignmentController',
        ]);

        /**
         * User-related APIs.
         */
        Route::group(
            ['prefix' => '/user/{user}', 'as' => 'user.'],
            function () {
                Route::post('/activate', 'UserController@activate')
                    ->name('activate');
                Route::post('/deactivate', 'UserController@deactivate')
                    ->name('deactivate');
            }
        );

        /**
         * Course-related APIs.
         */
        Route::group(
            ['prefix' => '/course/{course}', 'as' => 'course.'],
            function () {
                Route::get('/records', 'CourseController@records')
                    ->name('records');
                Route::post('/enroll', 'CourseController@enroll')
                    ->name('enroll');
                Route::post('/quit', 'CourseController@quit')
                    ->name('quit');
            }
        );

        /**
         * Assignment-related APIs
         */
        Route::group(
            ['prefix' => '/assignment/{assignment}', 'as' => 'assignment.'],
            function () {
                Route::post('/rate', 'AssignmentController@rate')
                    ->name('rate');
                Route::post('/finish', 'AssignmentController@finish')
                    ->name('finish');
                Route::post('/reset', 'AssignmentController@reset')
                    ->name('reset');
            }
        );

        /**
         * Personal-assignment-related APIs
         */
        Route::group(
            [
                'prefix' => '/personalAssignment/{personalAssignment}',
                'as'     => 'personalAssignment.',
            ],
            function () {
                Route::post('/finish', 'PersonalAssignmentController@finish')
                    ->name('finish');
                Route::post('/reset', 'PersonalAssignmentController@reset')
                    ->name('reset');
            }
        );

        /**
         * Blog-feed-releated APIs
         */
        Route::apiResource('blogFeed', 'BlogFeedController')
            ->only(['index', 'show']);
        Route::get('/blogFeed/xml', 'BlogFeedController@xml')->name('blogFeed.xml');
    }
);
