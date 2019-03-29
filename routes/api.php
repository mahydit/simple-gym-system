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
// 'auth:api' , 'verified'

Route::group([

    'middleware' => 'api',
    'prefix' => 'auth',

], function () {
    Route::post('login', 'Api\UsersController@login');
    Route::post('/register', 'Api\UsersController@store');

    Route::group([

        'middleware' => ['auth:api','verified'],    
    ], function () {

        Route::post('logout', 'Api\UsersController@logout');
        Route::post('refresh', 'Api\UsersController@refresh');
        Route::post('me', 'Api\UsersController@me');
        Route::put('/update' , 'Api\UsersController@update');
        Route::get('/show' , 'Api\UsersController@show');
        Route::post('/sessions/{session}/attend' , 'Api\UsersController@attend');
        Route::get('/sessions/history' , 'Api\UsersController@history');
        
    });

    
});
