<?php

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

$factory->define(App\User::class, function (Faker $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'ic' => $faker->numberBetween(100000000000,999999999999),
        'phone' => str_random(12),
        'is_verified' => true,
        'is_default_password' => false,
        'alt_contact_name'	=> $faker->name,
        'alt_contact_phone' => str_random(13),
        'remember_token' => str_random(10),
        'username' => str_random(6),
        'area_id'  => $faker->numberBetween(1,188),
        'ic_image_path' => "identification/default.jpg",
        'bank_name' => 'Maybank',
        'bank_account_number' => str_random(10),
        'bitcoin_address' => str_random(10)
    ];
});

$factory->state(App\User::class, 'unverified', function($faker) {
    return [
        'is_verified'   => false
    ];
});

$factory->state(App\User::class, 'password_unchanged', function($faker) {
    return [
        'is_default_password'   => true
    ];
});