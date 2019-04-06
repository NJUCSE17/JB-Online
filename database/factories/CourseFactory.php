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

$factory->define(
    Course::class,
    function (Faker $faker) {
        $notice = $faker->paragraph;

        return [
            'name'        => $faker->realText(20),
            'semester'    => $faker->numberBetween(1, 10),
            'start_time'  => $faker->dateTimeBetween('-1 year', 'now')->format(
                'Y-m-d H:i:s'
            ),
            'end_time'    => $faker->dateTimeBetween('now', '+1 year')->format(
                'Y-m-d H:i:s'
            ),
            'notice'      => $notice,
            'notice_html' => Parsedown::instance()->text($notice),
        ];
    }
);
