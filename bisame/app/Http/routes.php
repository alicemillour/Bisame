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

Route::group(['middleware' => ['web']], function () {
    //
});

Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::resource('user', 'UserController');
    Route::get('/home', 'HomeController@index');
    Route::resource('post', 'PostController', ['except' => ['show', 'edit', 'update']]);
    Route::get('post/tag/{tag}', 'PostController@indexTag');
    Route::resource('corpus', 'CorpusController');
    Route::resource('sentence', 'SentenceController');
    Route::resource('tag', 'TagController');
    Route::resource('query', 'QueryController');
});
