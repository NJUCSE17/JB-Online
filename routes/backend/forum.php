<?php

/**
 * All route names are prefixed with 'admin.forum'.
 */
Route::group([
    'prefix'     => 'forum',
    'as'         => 'forum.',
    'namespace'  => 'Forum',
    'middleware' => 'admin',
], function () {

    /*
    * Course Management
    */
    Route::group(['namespace' => 'Course'], function () {

        /*
        * Course Status
        */
        Route::get('course/deleted', 'CourseStatusController@getDeleted')->name('course.deleted');

        /*
        * Course CRUD
        */
        Route::resource('course', 'CourseController');

        /*
        * Specific course
        */
        Route::group(['prefix' => 'course/{course}'], function () {
            // Deleted
            Route::get('delete', 'CourseStatusController@delete')->name('course.delete-permanently');
            Route::get('restore', 'CourseStatusController@restore')->name('course.restore');
        });
    });

    /*
    * Assignment Management
    */
    Route::group(['namespace' => 'Assignment'], function () {

        /*
        * Assignment Status
        */
        Route::get('assignment/deleted', 'AssignmentStatusController@getDeleted')->name('assignment.deleted');

        /*
        * Assignment CRUD
        */
        Route::resource('assignment', 'AssignmentController');
        Route::get('assignment/specific/{course}', 'AssignmentController@specific')->name('assignment.specific');

        /*
        * Specific assignment
        */
        Route::group(['prefix' => 'assignment/{assignment}'], function () {
            // Deleted
            Route::get('delete', 'AssignmentStatusController@delete')->name('assignment.delete-permanently');
            Route::get('restore', 'AssignmentStatusController@restore')->name('assignment.restore');
        });
    });

    /*
    * Post Management
    */
    Route::group(['namespace' => 'Post'], function () {

        /*
        * Post Status
        */
        Route::get('post/deleted', 'PostStatusController@getDeleted')->name('post.deleted');

        /*
        * Post CRUD
        */
        Route::resource('post', 'PostController');
        Route::get('post/specific/{assignment}', 'PostController@specific')->name('post.specific');

        /*
        * Specific post
        */
        Route::group(['prefix' => 'post/{post}'], function () {
            // Deleted
            Route::get('delete', 'PostStatusController@delete')->name('post.delete-permanently');
            Route::get('restore', 'PostStatusController@restore')->name('post.restore');
        });
    });

    /*
    * Notice Management
    */
    Route::group(['namespace' => 'Notice'], function () {

        /*
        * Notice Status
        */
        Route::get('notice/deleted', 'NoticeStatusController@getDeleted')->name('notice.deleted');

        /*
        * Notice CRUD
        */
        Route::resource('notice', 'NoticeController');
        Route::get('notice/specific/{assignment}', 'NoticeController@specific')->name('notice.specific');

        /*
        * Specific notice
        */
        Route::group(['prefix' => 'notice/{notice}'], function () {
            // Deleted
            Route::get('delete', 'NoticeStatusController@delete')->name('notice.delete-permanently');
            Route::get('restore', 'NoticeStatusController@restore')->name('notice.restore');
        });
    });
});