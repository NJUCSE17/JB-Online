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

Auth::routes(
    [
        'register' => env('APP_ALLOW_REGISTER'),
        'verify'   => true,
    ]
);
Route::get('/activation', 'Auth\ActivationController@notice')
    ->name('activate.notice');
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
    ['namespace' => 'Web'],
    function () {
        Route::get('/', 'HomeController@welcome')->name('welcome');

        Route::group(
            ['middleware' => ['auth', 'verified', 'activated']],
            function () {
                Route::get('/home', 'HomeController@home')->name('home');
                Route::get('/user/{user}', 'HomeController@user')->name('user');

                Route::get('/course', 'CourseController@index')->name('course');

                Route::resource('blog', 'BlogController')
                    ->only(['index', 'show',]);
            }
        );
    }
);
