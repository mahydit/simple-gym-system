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
