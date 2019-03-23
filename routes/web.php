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


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
