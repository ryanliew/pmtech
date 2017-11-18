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

$factory->define(App\Payment::class, function (Faker $faker) {
    return [
        'is_verified'		=> false,
        'payment_slip_path'	=> "payment/default.jpg",
        'amount'			=> 1800.00,
        'user_id'			=> function() {
        	return factory('App\User')->create()->id;	
        }
    ];
});
