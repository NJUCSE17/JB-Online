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
        'middleware' => ['auth', 'verified', 'activated', 'throttle:20,1'],
    ],
    function () {
        Route::post('/register', 'SWController@register')->name('register');
    }
);