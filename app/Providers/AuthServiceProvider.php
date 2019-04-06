<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\PersonalAssignment;
use App\Models\Problem;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\CoursePolicy;
use App\Policies\PersonalAssignmentPolicy;
use App\Policies\ProblemPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies
        = [
            Assignment::class         => AssignmentPolicy::class,
            Course::class             => CoursePolicy::class,
            PersonalAssignment::class => PersonalAssignmentPolicy::class,
            Problem::class            => ProblemPolicy::class,
            User::class               => UserPolicy::class,
        ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //
    }
}
