<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
    // landing page
    Route::get('/', function () {
        return view('welcome');
    });

    // handle login/logout
    Route::get('/login/eveonline', 'LoginController@redirect');
    Route::get('/login/eveonline/callback', 'LoginController@callback');
    Route::get('/logout', 'LoginController@logout');

    // current system information
    Route::get('/location', 'LocationController@location');
    Route::get('/location/json', 'LocationController@location_json');

    // manage eve routes
    Route::get('/routes', 'RouteController@index');
    Route::get('/route/{everoute}', 'RoutePreviewController@index');
    Route::get('/route/{everoute}/edit', 'RouteController@index_update');
    Route::get('/route/{everoute}/loadwaypoints', 'RouteController@loadwaypoints');
    Route::post('/route', 'RouteController@store');
    Route::post('/route/paste', 'RouteController@paste');
    Route::post('/route/{everoute}', 'RouteController@update');
    Route::delete('/route/{everoute}', 'RouteController@destroy');

    // system information
    Route::get('/system/autocomplete', 'SystemController@autocomplete');
    Route::get('/system', 'SystemController@search');

    // user profile
    Route::get('/profile', 'ProfileController@index');
});
