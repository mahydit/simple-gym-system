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

Route::group(['middleware' => 'auth','forbid-banned-user','role:admin|citymanager|gymmanager'], function () {
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
    Route::post('dynamic_dependent/fetchCoaches', 'Web\SessionController@fetchCoaches')
    ->name('dynamicdependent.fetchCoaches');
    Route::post('dynamic_dependent/fetchGyms', 'Web\SessionController@fetchGyms')
    ->name('dynamicdependent.fetchGyms');
    Route::get('get-session-my-datatables', [
        'as'=>'get.session',
        'uses'=>'Web\SessionController@getSession'
        ]);

    Route::get('/revenues', 'Web\RevenueController@index')
    ->name('revenues.index');

    Route::get('/purchases', 'Web\PurchaseController@index')
    ->name('purchases.index');
    Route::get('/purchases/create', 'Web\PurchaseController@create')
    ->name('purchases.create');
    Route::post('/purchases', 'Web\PurchaseController@store')
    ->name('purchases.store');
    Route::get('/purchases/{purchase}', 'Web\PurchaseController@show')
    ->name('purchases.show');
    Route::get('get-purchase-my-datatables', [
        'as'=>'get.purchase',
        'uses'=>'Web\PurchaseController@getPurchase'
        ]);
            
    Route::get('/attendances', 'Web\AttendanceController@index')
    ->name('attendances.index');
    Route::get('/attendances/{attendance}', 'Web\AttendanceController@show')
    ->name('attendances.show');
    Route::get('get-attendance-my-datatables', [
        'as'=>'get.attendance',
        'uses'=>'Web\AttendanceController@getAttendance'
    ]);
});

Auth::routes(['verify' => true]);

Route::get('/banned', 'Web\BannedController@index')->name('BannedController.ban');
Route::get('/home', 'HomeController@index')->name('home');



//coaches//
Route::group(['middleware' => 'auth','middleware' => 'role:admin'], function () {
    Route::get('/coaches', 'Web\CoachController@index')
    ->name('coaches.index');
    Route::get('/coaches/create', 'Web\CoachController@create')
            ->name('coaches.create');
    Route::post('/coaches', 'Web\CoachController@store')
            ->name('coaches.store');
    Route::get('/coaches/{coach}', 'Web\CoachController@show')
            ->name('coaches.show');
    Route::get('/coaches/{coach}/edit', 'Web\CoachController@edit')
            ->name('coaches.edit');
    Route::put('/coaches/{coach}', 'Web\CoachController@update')
            ->name('coaches.update');
    Route::delete('/coaches/{coach}', 'Web\CoachController@destroy')
            ->name('coaches.destroy');
    Route::get('get-coach-my-datatables', ['as'=>'get.coach','uses'=>'Web\CoachController@getCoach']);
});



//packages//
Route::group(['middleware' => 'auth','middleware' => 'role:admin'], function () {
    Route::get('/packages', 'Web\PackagesController@index')
        ->name('packages.index');
    Route::get('/packages/create', 'Web\PackagesController@create')
        ->name('packages.create');
    Route::post('/packages', 'Web\PackagesController@store')
        ->name('packages.store');
    Route::get('/packages/{package}', 'Web\PackagesController@show')
        ->name('packages.show');
    Route::get('/packages/{package}/edit', 'Web\PackagesController@edit')
        ->name('packages.edit');
    Route::put('/packages/{package}', 'Web\PackagesController@update')
        ->name('packages.update');
    Route::delete('/packages/{package}', 'Web\PackagesController@destroy')
        ->name('packages.destroy');
    Route::get('get-package-my-datatables', ['as'=>'get.package','uses'=>'Web\PackagesController@getPackage']);
});

///// CITIES //////
Route::get('/cities', 'Web\CityController@index')   ->name('cities.index');
Route::get('/cities/create', 'Web\CityController@create')  ->name('cities.create');
Route::post('/cities', 'Web\CityController@store')   ->name('cities.store');
Route::get('/cities/{city}', 'Web\CityController@show')    ->name('cities.show');
Route::get('/cities/{city}/edit', 'Web\CityController@edit')    ->name('cities.edit');
Route::put('/cities/{city}', 'Web\CityController@update')  ->name('cities.update');
Route::delete('/cities/{city}/destroy', 'Web\CityController@destroy') ->name('cities.destroy');

///// GYMS //////
Route::group(['middleware' => 'auth', 'role:admin|citymanager'], function () {
    Route::get('/gyms', 'Web\GymController@index')
            ->name('gyms.index');
    Route::get('/gyms/create', 'Web\GymController@create')
            ->name('gyms.create');
    Route::post('/gyms', 'Web\GymController@store')
            ->name('gyms.store');
    Route::get('/gyms/{gym}', 'Web\GymController@show')
            ->name('gyms.show');
    Route::get('/gyms/{gym}/edit', 'Web\GymController@edit')
            ->name('gyms.edit');
    Route::put('/gyms/{gym}', 'Web\GymController@update')
            ->name('gyms.update');
    Route::delete('/gyms/{gym}/destroy', 'Web\GymController@destroy')
            ->name('gyms.destroy');
    Route::get('get-gym-my-datatables', ['as'=>'get.gym','uses'=>'Web\GymController@getGym']);
});

///// CITY MANAGERS //////
Route::group(['middleware' => 'auth', 'role:admin'], function () {
    Route::get('/cityManagers', 'Web\CityManagerController@index')   ->name('cityManagers.index');
    Route::get('/cityManagers/create', 'Web\CityManagerController@create')  ->name('cityManagers.create');
    Route::post('/cityManagers', 'Web\CityManagerController@store')   ->name('cityManagers.store');
    Route::get('/cityManagers/{citymanager}', 'Web\CityManagerController@show')    ->name('cityManagers.show');
    Route::get('/cityManagers/{citymanager}/edit', 'Web\CityManagerController@edit')    ->name('cityManagers.edit');
    Route::put('/cityManagers/{citymanager}', 'Web\CityManagerController@update')  ->name('cityManagers.update');
    Route::delete('/cityManagers/{citymanager}', 'Web\CityManagerController@destroy') ->name('cityManagers.destroy');
    Route::get('get-city_managers-my-datatables', [
        'as'=>'get.city_manager',
        'uses'=>'Web\CityManagerController@get_city_manager'
    ]);
});

///// GYM MANAGERS //////
Route::group(['middleware' => 'auth', 'role:admin|citymanager'], function () {
    Route::get('/gymManagers', 'Web\GymManagerController@index')   ->name('gymManagers.index');
    Route::get('/gymManagers/create', 'Web\GymManagerController@create')  ->name('gymManagers.create');
    Route::post('/gymManagers', 'Web\GymManagerController@store')   ->name('gymManagers.store');
    Route::get('/gymManagers/{gymmanager}', 'Web\GymManagerController@show')    ->name('gymManagers.show');
    Route::get('/gymManagers/{gymmanager}/edit', 'Web\GymManagerController@edit')    ->name('gymManagers.edit');
    Route::put('/gymManagers/{gymmanager}', 'Web\GymManagerController@update')  ->name('gymManagers.update');
    Route::delete('/gymManagers/{gymmanager}', 'Web\GymManagerController@destroy') ->name('gymManagers.destroy');
    Route::get('get-gym_managers-my-datatables', [
        'as'=>'get.gym_manager',
        'uses'=>'Web\GymManagerController@get_gym_manager'
    ]);
});
