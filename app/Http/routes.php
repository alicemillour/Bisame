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
    return view('home');
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
    Route::get('/', 'HomeController@index');
    Route::get('/chat', 'chatpageController@index');
    Route::get('user/{id}', 'UserController@showProfile');
    Route::resource('games', 'GameController', ['only' => ['update', 'show']]);
    Route::resource('training', 'TrainingController', ['only' => ['update', 'show']]);
    Route::get('/home/start', 'GameController@store');
    Route::get('/home/training', 'TrainingController@store');
    Route::get('/postags', 'PostagController@index');
    Route::get('/textes', 'TexteController@index');
    Route::resource('corpora', 'CorporaController');
    Route::get('/stats', 'StatsController@index');
    Route::get('contact', 'ContactController@showForm');
    Route::post('contact', 'ContactController@sendContactInfo');
    Route::get('/redirect', 'SocialAuthController@redirect');
    Route::get('/callback', 'SocialAuthController@callback');
});



Route::post('sendmessage', 'chatController@sendMessage');

//Route::get('admin', ['uses' => 'AdminController@index', 'middleware' => 'auth']);

//Route::post('/send', 'EmailController@send');
