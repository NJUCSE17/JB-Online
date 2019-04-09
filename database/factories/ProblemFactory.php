<?php

use App\Models\Assignment;
use App\Models\Problem;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(
    Problem::class,
    function (Faker $faker) {
        $fakeAssignment = factory(Assignment::class)->create();

        return [
            'course_id'     => $fakeAssignment->course->id,
            'assignment_id' => $fakeAssignment->id,
            'content'       => $faker->realText(50),
        ];
    }
);
