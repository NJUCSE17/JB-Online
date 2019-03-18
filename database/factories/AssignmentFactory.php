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
    $content = $faker->paragraph;
    return [
        'course_id'    => $fakeCourse->id,
        'name'         => $faker->realText(20),
        'content'      => $content,
        'content_html' => Parsedown::instance()->text($content),
        'due_time'     => $faker->dateTimeBetween('now', '+5 days')->format('Y-m-d H:i:s'),
    ];
});
