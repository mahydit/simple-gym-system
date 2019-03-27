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
    Route::delete('/sessions/{session}', 'Web\SessionController@destroy')->name('sessions.destroy');
    Route::get('get-session-my-datatables', ['as'=>'get.session','uses'=>'Web\SessionController@getSession']);
});

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


Route::get('admin/packages', 'Web\PackagesController@index')->name('packages.index');
Route::get('admin/packages/create', 'Web\PackagesController@create')->name('packages.create');
Route::post('admin/packages', 'Web\PackagesController@store')->name('packages.store');
Route::get('admin/packages/{package}/show', 'Web\PackagesController@show')->name('packages.show');
Route::get('admin/packages/{package}/edit', 'Web\PackagesController@edit')->name('packages.edit');
Route::put('admin/packages/{package}', 'Web\PackagesController@update')->name('packages.update');
Route::delete('admin/packages/{package}', 'Web\PackagesController@destroy')->name('packages.destroy');
Route::get('admin/packages/datatables', 'Web\PackagesController@get_data_table');
///// CITIES //////
Route::get('/cities', 'Web\CityController@index')   ->name('cities.index');
Route::get('/cities/create', 'Web\CityController@create')  ->name('cities.create');
Route::post('/cities', 'Web\CityController@store')   ->name('cities.store');
Route::get('/cities/{city}', 'Web\CityController@show')    ->name('cities.show');
Route::get('/cities/{city}/edit', 'Web\CityController@edit')    ->name('cities.edit');
Route::put('/cities/{city}', 'Web\CityController@update')  ->name('cities.update');
Route::delete('/cities/{city}/destroy', 'Web\CityController@destroy') ->name('cities.destroy');

///// GYMS //////
Route::get('/gyms', 'Web\GymController@index')   ->name('gyms.index');
Route::get('/gyms/create', 'Web\GymController@create')  ->name('gyms.create');
Route::post('/gyms', 'Web\GymController@store')   ->name('gyms.store');
Route::get('/gyms/{gym}', 'Web\GymController@show')    ->name('gyms.show');
Route::get('/gyms/{gym}/edit', 'Web\GymController@edit')    ->name('gyms.edit');
Route::put('/gyms/{gym}', 'Web\GymController@update')  ->name('gyms.update');
Route::delete('/gyms/{gym}/destroy', 'Web\GymController@destroy') ->name('gyms.destroy');

///// CITY MANAGERS //////
Route::get('/cityManagers', 'Web\CityManagerController@index')   ->name('cityManagers.index');
Route::get('/cityManagers/create', 'Web\CityManagerController@create')  ->name('cityManagers.create');
Route::post('/cityManagers', 'Web\CityManagerController@store')   ->name('cityManagers.store');
Route::get('/cityManagers/{citymanager}', 'Web\CityManagerController@show')    ->name('cityManagers.show');
Route::get('/cityManagers/{citymanager}/edit', 'Web\CityManagerController@edit')    ->name('cityManagers.edit');
Route::put('/cityManagers/{citymanager}', 'Web\CityManagerController@update')  ->name('cityManagers.update');
Route::delete('/cityManagers/{citymanager}/destroy', 'Web\CityManagerController@destroy') ->name('cityManagers.destroy');

///// GYM MANAGERS //////
Route::get('/gymManagers', 'Web\GymManagerController@index')   ->name('gymManagers.index');
Route::get('/gymManagers/create', 'Web\GymManagerController@create')  ->name('gymManagers.create');
Route::post('/gymManagers', 'Web\GymManagerController@store')   ->name('gymManagers.store');
Route::get('/gymManagers/{gymmanager}', 'Web\GymManagerController@show')    ->name('gymManagers.show');
Route::get('/gymManagers/{gymmanager}/edit', 'Web\GymManagerController@edit')    ->name('gymManagers.edit');
Route::put('/gymManagers/{gymmanager}', 'Web\GymManagerController@update')  ->name('gymManagers.update');
Route::delete('/gymManagers/{gymmanager}/destroy', 'Web\GymManagerController@destroy') ->name('gymManagers.destroy');
