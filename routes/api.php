<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',
    'verify' => true,

], function ($router) {

    Route::post('login', 'Api\UsersController@login');
    Route::post('logout', 'Api\UsersController@logout');
    Route::post('refresh', 'Api\UsersController@refresh');
    Route::post('me', 'Api\UsersController@me');
    Route::post('/users', 'Api\UsersController@store');
    
    
});
