<?php

namespace App\Providers;

use App\Models\Assignment;
use App\Models\Course;
use App\Models\PersonalAssignment;
use App\Models\User;
use App\Policies\AssignmentPolicy;
use App\Policies\CoursePolicy;
use App\Policies\PersonalAssignmentPolicy;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

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

        Passport::routes();
    }
}
