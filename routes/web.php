<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
	return redirect(route('login'));
});

Auth::routes();

Route::get('/test', function() {
	foreach(\App\Area::all() as $area)
	{
		echo "['name' => '{$area->name}', 'state_id' => {$area->state_id}],<br>";
	}
});

Route::get('/home', 'HomeController@index')->name('home');

Route::get('machines', 'MachineController@index')->name('machines');
Route::post('machines', 'MachineController@store')->name('machines');
Route::post('machine/{machine}', 'MachineController@update')->name('machine');
Route::delete('machine/{machine}', 'MachineController@destroy')->name('machine');

Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/new', 'UserController@create')->name('user.create');
Route::post('/user/new', 'UserController@store')->name('user.create');
Route::get('/user/{user}', 'UserController@show')->name('user');
Route::post('/user/{user}', 'UserController@update')->name('user');
Route::delete('/user/{user}', 'UserController@destroy')->name('user');


Route::post('/payment/{payment}', 'PaymentController@update')->name('payment');