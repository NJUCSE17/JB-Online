<?php

/**
 * Global Routes
 * Routes that are used between both frontend and backend.
 */
Route::get('img/private/{path}', function($path){
    $server = \League\Glide\ServerFactory::create([
        'response' => new \League\Glide\Responses\LaravelResponseFactory(app('request')),
        'source' => app('filesystem')->disk('private')->getDriver(),
        'cache' => storage_path('glide'),
    ]);
    return $server->getImageResponse($path, \Illuminate\Support\Facades\Input::query());
})->where('path', '.+');
Route::get('img/public/{path}', function($path){
    $server = \League\Glide\ServerFactory::create([
        'response' => new \League\Glide\Responses\LaravelResponseFactory(app('request')),
        'source' => app('filesystem')->disk('public')->getDriver(),
        'cache' => storage_path('glide'),
    ]);
    return $server->getImageResponse($path, \Illuminate\Support\Facades\Input::query());
})->where('path', '.+');

// Switch between the included languages
Route::get('lang/{lang}', 'LanguageController');

/*
 * Frontend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Frontend', 'predix' => 'frontend', 'as' => 'frontend.'], function () {
    include_route_files(__DIR__.'/frontend/');
});

/*
 * Backend Routes
 * Namespaces indicate folder structure
 */
Route::group(['namespace' => 'Backend', 'prefix' => 'admin', 'as' => 'admin.', 'middleware' => 'admin'], function () {
    /*
     * These routes need view-backend permission
     * (good if you want to allow more than one group in the backend,
     * then limit the backend features by different roles or permissions)
     *
     * Note: Administrator has all permissions so you do not have to specify the administrator role everywhere.
     * These routes can not be hit if the password is expired
     */
    include_route_files(__DIR__.'/backend/');
});