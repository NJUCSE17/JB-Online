<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\AssignmentFinishRecord;
use App\Models\Blog;
use App\Models\Course;
use App\Models\CourseEnrollRecord;
use App\Models\PersonalAssignment;
use App\Models\Problem;
use App\Models\User;
use App\Observers\AssignmentFinishRecordObserver;
use App\Observers\AssignmentObserver;
use App\Observers\BlogObserver;
use App\Observers\CourseEnrollRecordObserver;
use App\Observers\CourseObserver;
use App\Observers\PersonalAssignmentObserver;
use App\Observers\ProblemObserver;
use App\Observers\UserObserver;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);

        AssignmentFinishRecord::observe(AssignmentFinishRecordObserver::class);
        Assignment::observe(AssignmentObserver::class);
        Blog::observe(BlogObserver::class);
        CourseEnrollRecord::observe(CourseEnrollRecordObserver::class);
        Course::observe(CourseObserver::class);
        PersonalAssignment::observe(PersonalAssignmentObserver::class);
        Problem::observe(ProblemObserver::class);
        User::observe(UserObserver::class);
    }
}
