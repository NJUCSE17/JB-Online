<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('/', 'HomeController@index')->name('index');
Route::get('about', 'HomeController@about')->name('about');

/*
 * These frontend controllers require the user to be logged in
 * All route names are prefixed with 'frontend.'
 * These routes can not be hit if the password is expired
 */
Route::group(['middleware' => ['auth', 'password_expires']], function () {
    Route::get('home', 'HomeController@home')->name('home');
    Route::get('blog', 'HomeController@blog')->name('blog');

    Route::group(['namespace' => 'User', 'as' => 'user.'], function () {
        Route::get('account', 'AccountController@index')->name('account');
        Route::patch('profile/update', 'ProfileController@update')->name('profile.update');
    });

    Route::group(['namespace' => 'Forum', 'prefix'=>'course', 'as' => 'forum.'], function () {
        Route::get('/', 'CourseController@index')->name('course');

        Route::get('personal/finished', 'PersonalController@finished')->name('personal.finished');
        Route::get('personal/deleted', 'PersonalController@getDeleted')->name('personal.deleted');
        Route::resource('personal', 'PersonalController')->parameters(['personal' => 'assignment']);
        Route::group(['prefix' => 'personal/{assignment}'], function () {
            Route::get('delete', 'PersonalController@delete')->name('personal.delete-permanently');
            Route::get('restore', 'PersonalController@restore')->name('personal.restore');
            Route::group(['middleware' => 'throttle:60,1'], function () {
                Route::post('finish', 'AssignmentController@finish')->name('personal.finish');
                Route::post('reset', 'AssignmentController@reset')->name('personal.reset');
            });
        });

        Route::group(['prefix' => '/{course}'], function () {
            Route::get('/', 'CourseController@specific')->name('course.view');

            Route::post('check/student/{user?}', 'CourseController@checkStudent')->name('course.check.student');
            Route::post('check/admin/{user?}', 'CourseController@checkAdmin')->name('course.check.admin');
            Route::post('add/student', 'CourseController@addStudent')->name('course.add.student.myself');
            Route::post('delete/user', 'CourseController@deleteUser')->name('course.delete.user.myself');
            Route::group(['middleware' => 'admin'], function () {
                // Only admin can add admin, and control other users.
                Route::post('add/student/{user?}', 'CourseController@addStudent')->name('course.add.student');
                Route::post('add/admin/{user?}', 'CourseController@addAdmin')->name('course.add.admin');
                Route::post('delete/user/{user?}', 'CourseController@deleteUser')->name('course.delete.user');
            });

            Route::group(['prefix' => 'assignment/{assignment}'], function () {
                Route::get('/{sort}', 'AssignmentController@index')->name('assignment.view');
                Route::resource('post', 'PostController');

                Route::group(['middleware' => 'throttle:60,1'], function () {
                    Route::post('finish', 'AssignmentController@finish')->name('assignment.finish');
                    Route::post('reset', 'AssignmentController@reset')->name('assignment.reset');

                    Route::group(['prefix' => 'problem/{problem}'], function() {
                        Route::post('voteup', 'ProblemController@voteUp')->name('problem.voteup');
                        Route::post('votedown', 'ProblemController@voteDown')->name('problem.votedown');
                    });

                    Route::group(['prefix' => 'post/{post}'], function() {
                        Route::post('voteup', 'PostController@voteUp')->name('post.voteup');
                        Route::post('votedown', 'PostController@voteDown')->name('post.votedown');
                    });
                });
            });
        });
    });
});
