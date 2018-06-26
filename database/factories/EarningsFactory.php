<?php

use App\Machine;
use Carbon\Carbon;
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

$factory->define(App\Earning::class, function (Faker $faker) {
    static $password;

    $machine = Machine::first();

    return [
        'date' 			=> $faker->date,
        'amount'		=> $faker->randomFloat,
        'machine_id' 	=> $machine->id
    ];
});
