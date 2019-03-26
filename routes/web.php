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

Route::get('/dashboard', function () {
    return view('layouts.dashboard');
});

Route::get('/sessions', 'Web\SessionController@index')->name('session.index');
Route::get('/sessions/create', 'Web\SessionController@create')->name('session.create');


Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('admin', function () {
    return view('admin');
});

Route::get('admin/coaches', 'Web\CoachController@index')->name('coaches.index');
Route::get('admin/coaches/create', 'Web\CoachController@create')->name('coaches.create');
Route::post('admin/coaches', 'Web\CoachController@store')->name('coaches.store');
Route::get('admin/coaches/{coach}/show', 'Web\CoachController@show')->name('coaches.show');
Route::get('admin/coaches/{coach}/edit', 'Web\CoachController@edit')->name('coaches.edit');
Route::put('admin/coaches/{coach}', 'Web\CoachController@update')->name('coaches.update');
Route::delete('admin/coaches/{coach}', 'Web\CoachController@destroy')->name('coaches.destroy');

Route::get('admin/coaches/datatables', 'Web\CoachController@get_data_table');
