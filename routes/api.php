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
Route::get('app/{system?}', 'API\HomeController@app')->name('api.app');

Route::group(['namespace' => 'API', 'middleware' => 'auth:api'], function () {
    Route::get('heatmap', 'HomeController@heatmap')->name('api.heatmap');

    Route::group(['namespace' => 'Forum'], function () {
        Route::get('notice', 'NoticeController@getNotice');

        Route::get('assignments', 'AssignmentController@getAssignments');
        Route::group(['prefix' => 'assignment/{assignment}'], function () {
            Route::post('finish', 'AssignmentController@finishAssignment');
            Route::post('reset', 'AssignmentController@resetAssignment');
        });

        Route::group(['prefix' => 'course/{course}'], function () {
            Route::get('check/student/{user?}', 'CourseController@checkStudent')->name('api.forum.course.check.student');
            Route::get('check/admin/{user?}', 'CourseController@checkAdmin')->name('api.forum.course.check.admin');
            Route::post('add/student', 'CourseController@addStudent')->name('api.forum.course.add.student.myself');
            Route::post('delete/user', 'CourseController@deleteUser')->name('api.forum.course.delete.user.myself');
            Route::group(['middleware' => 'admin'], function () {
                // Only admin can add admin, and control other users.
                Route::post('add/student/{user?}', 'CourseController@addStudent')->name('api.forum.course.add.student');
                Route::post('add/admin/{user?}', 'CourseController@addAdmin')->name('api.forum.course.add.admin');
                Route::post('delete/user/{user?}', 'CourseController@deleteUser')->name('api.forum.course.delete.user');
            });
        });
    });
});
