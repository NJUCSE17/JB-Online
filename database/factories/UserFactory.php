<?php

use App\Models\User;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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
    User::class,
    function (Faker $faker) {
        return [
            'student_id'        => $faker->numberBetween(100000000, 200000000),
            'name'              => $faker->name,
            'email'             => $faker->unique()->safeEmail,
            'want_email'        => $faker->boolean,
            'avatar_type'       => $faker->randomElement(
                array('upload', 'github', 'gravatar')
            ),
            'avatar_upload'     => $faker->imageUrl(),
            'avatar_github'     => $faker->imageUrl(),
            'blog'              => $faker->url,
            'email_verified_at' => now(),
            'activated_at'      => now(),
            'privilege_level'   => 3,
            'password'          => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            // password
            'remember_token'    => Str::random(10),
        ];
    }
);
