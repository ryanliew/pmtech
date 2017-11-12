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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('machines', 'MachineController@index')->name('machines');
Route::post('machines', 'MachineController@store')->name('machines');
Route::post('machine/{machine}', 'MachineController@update')->name('machine');
Route::delete('machine/{machine}', 'MachineController@destroy')->name('machine');
