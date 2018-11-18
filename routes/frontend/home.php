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
        });

        Route::group(['prefix' => '/{course}'], function () {
            Route::get('/', 'CourseController@specific')->name('course.view');
            Route::group(['prefix' => 'assignment/{assignment}'], function () {
                Route::get('finish', 'AssignmentController@finish')->name('assignment.finish');
                Route::get('reset', 'AssignmentController@reset')->name('assignment.reset');
                Route::get('/{sort}', 'AssignmentController@index')->name('assignment.view');
                Route::resource('post', 'PostController');

                Route::group(['prefix' => 'problem/{problem}'], function() {
                    Route::get('voteup', 'ProblemController@voteUp')->name('problem.voteup');
                    Route::get('votedown', 'ProblemController@voteDown')->name('problem.votedown');
                });

                Route::group(['prefix' => 'post/{post}'], function() {
                    Route::get('voteup', 'PostController@voteUp')->name('post.voteup');
                    Route::get('votedown', 'PostController@voteDown')->name('post.votedown');
                });
            });
        });
    });
});
