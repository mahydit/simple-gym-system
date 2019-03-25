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

Route::group(['middleware' => 'auth'], function () {
    Route::get('/sessions', 'Web\SessionController@index')
    ->name('sessions.index');
    Route::get('/sessions/create', 'Web\SessionController@create')
    ->name('sessions.create');
    Route::post('/sessions', 'Web\SessionController@store')
    ->name('sessions.store');
    Route::get('/sessions/{session}', 'Web\SessionController@show')
    ->name('sessions.show');
    Route::get('/sessions/{session}/edit', 'Web\SessionController@edit')
    ->name('sessions.edit');
    Route::put('/sessions/{session}', 'Web\SessionController@update')
    ->name('sessions.update');
    Route::delete('/sessions/{session}', 'Web\SessionController@destroy')
    ->name('sessions.destroy');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

///// CITIES //////
Route::get      ('/cities',               'CityController@index')   ->name('cities.index');
Route::get      ('/cities/create',        'CityController@create')  ->name('cities.create');
Route::post     ('/cities',               'CityController@store')   ->name('cities.store');
Route::get      ('/cities/{city}',        'CityController@show')    ->name('cities.show');
Route::get      ('/cities/{city}/edit',   'CityController@edit')    ->name('cities.edit');
Route::put      ('/cities/{city}',        'CityController@update')  ->name('cities.update');
Route::delete   ('/cities/{city}/destroy','CityController@destroy') ->name('cities.destroy');

///// GYMS //////
Route::get      ('/gyms',              'GymController@index')   ->name('gyms.index');
Route::get      ('/gyms/create',       'GymController@create')  ->name('gyms.create');
Route::post     ('/gyms',              'GymController@store')   ->name('gyms.store');
Route::get      ('/gyms/{gym}',        'GymController@show')    ->name('gyms.show');
Route::get      ('/gyms/{gym}/edit',   'GymController@edit')    ->name('gyms.edit');
Route::put      ('/gyms/{gym}',        'GymController@update')  ->name('gyms.update');
Route::delete   ('/gyms/{gym}/destroy','GymController@destroy') ->name('gyms.destroy');

///// CITY MANAGERS //////
Route::get      ('/cityManagers',                      'CityManagerController@index')   ->name('cityManagers.index');
Route::get      ('/cityManagers/create',               'CityManagerController@create')  ->name('cityManagers.create');
Route::post     ('/cityManagers',                      'CityManagerController@store')   ->name('cityManagers.store');
Route::get      ('/cityManagers/{citymanager}',        'CityManagerController@show')    ->name('cityManagers.show');
Route::get      ('/cityManagers/{citymanager}/edit',   'CityManagerController@edit')    ->name('cityManagers.edit');
Route::put      ('/cityManagers/{citymanager}',        'CityManagerController@update')  ->name('cityManagers.update');
Route::delete   ('/cityManagers/{citymanager}/destroy','CityManagerController@destroy') ->name('cityManagers.destroy');

///// GYM MANAGERS //////
Route::get      ('/gymManagers',                     'CityManagerController@index')   ->name('cityManagers.index');
Route::get      ('/gymManagers/create',              'CityManagerController@create')  ->name('cityManagers.create');
Route::post     ('/gymManagers',                     'CityManagerController@store')   ->name('cityManagers.store');
Route::get      ('/gymManagers/{gymmanager}',        'CityManagerController@show')    ->name('cityManagers.show');
Route::get      ('/gymManagers/{gymmanager}/edit',   'CityManagerController@edit')    ->name('cityManagers.edit');
Route::put      ('/gymManagers/{gymmanager}',        'CityManagerController@update')  ->name('cityManagers.update');
Route::delete   ('/gymManagers/{gymmanager}/destroy','CityManagerController@destroy') ->name('cityManagers.destroy');