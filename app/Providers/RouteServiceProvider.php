<?php

namespace App\Providers;

use App\Models\Auth\User;
use App\Models\Forum\Notice;
use App\Models\Forum\Post;
use App\Models\Forum\Course;
use App\Models\Forum\Assignment;
use App\Models\Forum\Problem;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

/**
 * Class RouteServiceProvider.
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to your controller routes.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @return void
     */
    public function boot()
    {
        /*
        * Register route model bindings
        */

        /*
         * Allow this to select all users regardless of status
         */
        $this->bind('user', function ($value) {
            $user = new User;

            return User::withTrashed()->where($user->getRouteKeyName(), $value)->first();
        });

        /*
         * Allow this to select all courses regardless of status
         */
        $this->bind('course', function ($value) {
            $course = new Course;

            return Course::withTrashed()->where($course->getRouteKeyName(), $value)->first();
        });

        /*
         * Allow this to select all assignments regardless of status
         */
        $this->bind('assignment', function ($value) {
            $assignment = new Assignment;

            return Assignment::withTrashed()->where($assignment->getRouteKeyName(), $value)->first();
        });


        /*
         * Allow this to select all posts regardless of status
         */
        $this->bind('problem', function ($value) {
            $problem = new Problem();

            return Problem::withTrashed()->where($problem->getRouteKeyName(), $value)->first();
        });


        /*
         * Allow this to select all posts regardless of status
         */
        $this->bind('post', function ($value) {
            $post = new Post();

            return Post::withTrashed()->where($post->getRouteKeyName(), $value)->first();
        });


        /*
         * Allow this to select all notices regardless of status
         */
        $this->bind('notice', function ($value) {
            $notice = new Notice();

            return Notice::withTrashed()->where($notice->getRouteKeyName(), $value)->first();
        });


        parent::boot();
    }

    /**
     * Define the routes for the application.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();

        $this->mapWebRoutes();

        //
    }

    /**
     * Define the "web" routes for the application.
     *
     * These routes all receive session state, CSRF protection, etc.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web')
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    }

    /**
     * Define the "api" routes for the application.
     *
     * These routes are typically stateless.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }
}
