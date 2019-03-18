<?php

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

$factory->define(Course::class, function (Faker $faker) {
    return [
        'name'        => $faker->name,
        'semester'    => $faker->numberBetween(1, 10),
        'start_time'  => $faker->dateTimeBetween('-1 year', 'now'),
        'end_time'    => $faker->dateTimeBetween('now', '+1 year'),
        'notice'      => $faker->paragraph,
        'notice_html' => $faker->paragraph,
    ];
});
