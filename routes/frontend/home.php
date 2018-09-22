<?php

/**
 * Frontend Controllers
 * All route names are prefixed with 'frontend.'.
 */
Route::get('about', 'HomeController@about')->name('about');
Route::get('/', 'HomeController@index')->name('index');

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

    Route::group(['namespace' => 'Forum', 'prefix'=>'course/{course}', 'as' => 'forum.'], function () {
        Route::get('/', 'CourseController@index')->name('course.view');

        Route::group(['prefix' => 'assignment/{assignment}'], function () {
            Route::get('finish', 'AssignmentController@finish')->name('assignment.finish');
            Route::get('reset', 'AssignmentController@reset')->name('assignment.reset');
            Route::get('/{sort}', 'AssignmentController@index')->name('assignment.view');
            Route::resource('post', 'PostController');

        });
    });
});
