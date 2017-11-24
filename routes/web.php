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

Route::get('/phpinfo', function() {
	phpinfo();
});
Route::get('/test', function() {
	foreach(\App\Area::all() as $area)
	{
		echo "['name' => '{$area->name}', 'state_id' => {$area->state_id}],<br>";
	}
});

Route::get('/repeater', 'HomeController@repeater');

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/settings', 'SettingController@edit')->name('settings');
Route::post('/settings', 'SettingController@update')->name('settings');

Route::get('machines', 'MachineController@index')->name('machines');
Route::post('machines', 'MachineController@store')->name('machines');
Route::get('machine/{machine}', 'MachineController@show')->name('machine');
Route::post('machine/{machine}', 'MachineController@update')->name('machine');
Route::delete('machine/{machine}', 'MachineController@destroy')->name('machine');


Route::post('unit/{unit}', 'UnitController@update')->name('unit');
Route::delete('unit/{unit}', 'UnitController@destroy')->name('unit');


Route::get('/users', 'UserController@index')->name('users');
Route::get('/user/new', 'UserController@create')->name('user.create');
Route::post('/user/new', 'UserController@store')->name('user.create');
Route::get('/user/profile', 'UserController@edit')->name('user.profile');
Route::post('/user/profile', 'UserController@update')->name('user.profile');
Route::get('/user/edit/{user}', 'UserController@edit')->name('user.edit');
Route::post('/user/edit/{user}', 'UserController@update')->name('user.edit');
Route::post('/user/verify/{user}', 'UserController@verify')->name('user.verify');
Route::delete('/user/verify/{user}', 'UserController@destroy')->name('user.verify');
Route::post('/user/ic/{user}', 'UserController@updateIdentity')->name('user.ic');
Route::get('/user/{user}', 'UserController@show')->name('user');
Route::post('/user/{user}', 'UserController@update')->name('user');


Route::post('payments', 'PaymentController@store')->name('payments');
Route::post('/payment/{payment}', 'PaymentController@update')->name('payment');


Route::post('earnings/{machine}', 'EarningController@store')->name('earning');
Route::patch('earnings/{earning}', 'EarningController@update')->name('earning');


Route::get('/transactions/{user}', 'TransactionController@index')->name('transactions');