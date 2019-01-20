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

Route::get('/', 'WelcomeController@welcome')->name('home');


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

// Route::group(['middleware' => 'web'], function () {
    Route::auth();
    Route::get('/home-game', 'HomeController@index')->name('home-game');
    Route::get('/info', 'InfoController@index')->name('info');
    Route::get('/alternative-participation', 'InfoController@index')->name('alternative-participation');
    // Route::get('/', 'HomeController@index');
    Route::get('/chat', 'chatpageController@index');
//    Route::get('user/{id}', 'UserController@showProfile');
    Route::get('user/delete', 'UserController@getDelete');
    Route::resource('games', 'GameController', ['only' => ['update', 'show']]);
    Route::post('validate-training', 'TrainingController@validateTraining')->name('validate-training');
    Route::get('training/{postag}', 'TrainingController@training');
    Route::resource('training', 'TrainingController', ['only' => ['update', 'show']]);
    Route::get('/home/start', 'GameController@store');
    Route::get('/home/training', 'TrainingController@store');
    Route::get('/postags/by-word', 'PostagController@getByWord');
    Route::resource('postag', 'PostagController');
    Route::get('/textes', 'TexteController@index');
    Route::resource('corpora', 'CorporaController');
    Route::resource('downloads', 'DownloadController');
    Route::get('/stats', 'StatsController@index');
    Route::get('contact', 'ContactController@showForm')->name('contact');
    Route::post('contact', 'ContactController@sendContactInfo');
    Route::post('create-annotation', 'AnnotationController@create')->name('create-annotation');
    Route::get('teaser', 'TeaserController@show');
// });

Route::get('/asset', [
	'uses' => 'AssetController@get', 
	'as' => 'asset'
]);

Route::post('sendmessage', 'chatController@sendMessage');

Route::get('admin', ['middleware' => 'admin', 'uses' => 'AdminController@index']);

Route::get('/home', 'UserController@home')->middleware('auth')->name('users.home');
Route::get('/language', 'WelcomeController@language');

Route::get('recipes/favorite', 'RecipeController@favorite')->name('recipes.favorite');
Route::get('recipes/search', 'RecipeController@search')->name('recipes.search');
Route::get('recipes/to-annotate', 'RecipeController@toAnnotate')->name('recipes.to-annotate');
Route::get('recipes/add-alt-version', 'RecipeController@addAltVersion')->name('recipes.add-alt-version');
Route::get('recipes/to-validate', 'RecipeController@toValidate')->name('recipes.to-validate');
Route::post('recipes/add-anecdote', 'RecipeController@addAnecdote');
Route::post('recipes/{recipe}/add-media', 'RecipeController@addMedia')->name('recipes.add-media');
Route::post('recipes/{recipe}/annotated', 'RecipeController@flagAsAnnotated')->name('recipes.flag-as-annotated');
Route::post('recipes/{recipe}/validated', 'RecipeController@flagAsValidated')->name('recipes.flag-as-validated');

Route::get('recipes/{recipe}/alternative-versions', 'RecipeController@alternativeVersions')->name('recipes.alternative-versions');
Route::get('recipes/{recipe}/annotations', 'RecipeController@annotations')->name('recipes.annotations');
Route::resource('recipes', 'RecipeController');
Route::get('recipes/user/{user}', 'RecipeController@user')->name('recipes.user');

Route::post('users/update-password', 'UserController@updatePassword')->name('users.update-password');
Route::post('users/update-languages', 'UserController@updateLanguages')->name('users.update-languages');
Route::post('users/update-city', 'UserController@updateCity')->name('users.update-city');
Route::resource('users', 'UserController');
Route::post('users/update-position', 'UserController@updatePosition')->name('users.update-position');
Route::post('users/update-age', 'UserController@updateAge')->name('users.update-age');
Route::post('users/update-avatar', 'UserController@updateAvatar')->name('users.update-avatar');
Route::post('users/update-notifications', 'UserController@updateNotifications')->name('users.update-notifications');
Route::get('words/{word}', 'WordController@index')->name('words.show');
        
Route::resource('translations', 'AlternativeTextController')->middleware('auth');
Route::resource('translations-words', 'AlternativeWordController')->middleware('auth');
Route::resource('likes', 'LikeController');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/laravel-filemanager', '\Unisharp\Laravelfilemanager\controllers\LfmController@show');
    Route::post('/laravel-filemanager/upload', '\Unisharp\Laravelfilemanager\controllers\UploadController@upload');
});

//ReportController
Route::post('report/send', 'ReportController@postSend');

//ReportController
Route::post('media/upload', 'MediaController@upload')->name('media.upload');
Route::put('media/upload', 'MediaController@upload');

// DiscussionController
Route::group(array('before' => 'auth'), function ()
{
  Route::get('game/history', 'DiscussionController@getHistory')->name('history');
  Route::get('discussion/index/{id}', 'DiscussionController@getIndex');
  Route::get('discussion', 'DiscussionController@getIndex')->name('index-discussion');
  Route::get('discussion/thread', 'DiscussionController@getThread');
  Route::get('discussion/follow-thread', 'DiscussionController@getFollowThread');
  Route::get('discussion/un-follow-thread', 'DiscussionController@getUnFollowThread');
  Route::post('discussion/new', 'DiscussionController@postNew');
});
Route::group(array('before' => 'admin'), function ()
{
  Route::get('discussion/delete', 'DiscussionController@getDelete');
});

//Route::get('admin', ['uses' => 'AdminController@index', 'middleware' => 'auth']);

//Route::post('/send', 'EmailController@send');
