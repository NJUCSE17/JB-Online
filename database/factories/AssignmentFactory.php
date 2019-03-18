<?php

use App\Models\Assignment;
use App\Models\Course;
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

$factory->define(Assignment::class, function (Faker $faker) {
    $fakeCourse = factory(Course::class)->create();
    return [
        'course_id'    => $fakeCourse->id,
        'name'         => $faker->name,
        'content'      => $faker->paragraph,
        'content_html' => $faker->paragraph,
        'due_time'     => $faker->dateTime,
    ];
});
