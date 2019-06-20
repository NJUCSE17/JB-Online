<?php

/*
|--------------------------------------------------------------------------
| SW (Service Worker) Routes
|--------------------------------------------------------------------------
|
| API used for service worker authorization and notification pooling.
|
 */

Route::group(
    [
        'as'         => 'sw.',
        'namespace'  => 'SW',
        'middleware' => ['auth:api', 'verified', 'activated'],
    ],
    function () {
        Route::get('/poll', 'SWController@poll')->name('poll');
        Route::post('/register', 'SWController@register')->name('register');
    }
);