<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@welcome')->name('welcome');

Auth::routes(['register' => env('APP_ALLOW_REGISTER')]);
Route::group(
    ['namespace' => 'Auth', 'as' => 'auth'],
    function () {
        Route::get('/login/github', 'SocialLoginController@githubRedirect')
            ->name('login.github.redirect');
        Route::get(
            '/login/github/callback',
            'SocialLoginController@githubCallback'
        )->name('login.github.callback');
    }
);

Route::group(
    ['middleware' => 'auth'],
    function () {
        Route::get('/home', 'HomeController@home')->name('home');
    }
);
