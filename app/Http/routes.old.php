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

Route::get('/', function () {
    return view('welcome');
});

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

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home', 'HomeController@index');
    //Route::get('/', 'WelcomeController@index');

    Route::resource('games', 'GameController', ['only' => ['update', 'show']]);
    Route::resource('training', 'TrainingController', ['only' => ['update', 'show']]);
    Route::get('/home/start', 'GameController@store');
    Route::get('/home/training', 'TrainingController@store');
    Route::get('/postags', 'PostagController@index');
});
