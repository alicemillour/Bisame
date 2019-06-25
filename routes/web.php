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
    Route::resource('downloads', 'DownloadController@index');
    Route::get('downloads', 'DownloadController@index')->name('downloads');
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

Route::get('poems/favorite', 'PoemController@favorite')->name('poems.favorite');
Route::get('poems/search', 'PoemController@search')->name('poems.search');
Route::get('poems/to-annotate', 'PoemController@toAnnotate')->name('poems.to-annotate');
Route::get('poems/add-alt-version', 'PoemController@addAltVersion')->name('poems.add-alt-version');
Route::get('poems/to-validate', 'PoemController@toValidate')->name('poems.to-validate');
Route::post('poems/add-anecdote', 'PoemController@addAnecdote');
Route::post('poems/{recipe}/add-media', 'PoemController@addMedia')->name('poems.add-media');
Route::post('poems/{recipe}/annotated', 'PoemController@flagAsAnnotated')->name('poems.flag-as-annotated');
Route::post('poems/{recipe}/validated', 'PoemController@flagAsValidated')->name('poems.flag-as-validated');

Route::get('poems/{recipe}/alternative-versions', 'PoemController@alternativeVersions')->name('poems.alternative-versions');
Route::get('poems/{recipe}/annotations', 'PoemController@annotations')->name('poems.annotations');
Route::resource('poems', 'PoemController');
Route::get('poems/user/{user}', 'PoemController@user')->name('poems.user');


Route::get('freetexts/favorite', 'FreetextController@favorite')->name('freetexts.favorite');
Route::get('freetexts/search', 'FreetextController@search')->name('freetexts.search');
Route::get('freetexts/to-annotate', 'FreetextController@toAnnotate')->name('freetexts.to-annotate');
Route::get('freetexts/add-alt-version', 'FreetextController@addAltVersion')->name('freetexts.add-alt-version');
Route::get('freetexts/to-validate', 'FreetextController@toValidate')->name('freetexts.to-validate');
Route::post('freetexts/add-anecdote', 'FreetextController@addAnecdote');
Route::post('freetexts/{recipe}/add-media', 'FreetextController@addMedia')->name('freetexts.add-media');
Route::post('freetexts/{recipe}/annotated', 'FreetextController@flagAsAnnotated')->name('freetexts.flag-as-annotated');
Route::post('freetexts/{recipe}/validated', 'FreetextController@flagAsValidated')->name('freetexts.flag-as-validated');

Route::get('freetexts/{recipe}/alternative-versions', 'FreetextController@alternativeVersions')->name('freetexts.alternative-versions');
Route::get('freetexts/{recipe}/annotations', 'FreetextController@annotations')->name('freetexts.annotations');
Route::resource('freetexts', 'FreetextController');
Route::get('freetexts/user/{user}', 'FreetextController@user')->name('freetexts.user');


Route::get('proverbs/favorite', 'ProverbController@favorite')->name('proverbs.favorite');
Route::get('proverbs/search', 'ProverbController@search')->name('proverbs.search');
Route::get('proverbs/to-annotate', 'ProverbController@toAnnotate')->name('proverbs.to-annotate');
Route::get('proverbs/add-alt-version', 'ProverbController@addAltVersion')->name('proverbs.add-alt-version');
Route::get('proverbs/to-validate', 'ProverbController@toValidate')->name('proverbs.to-validate');
Route::post('proverbs/add-anecdote', 'ProverbController@addAnecdote');
Route::post('proverbs/{recipe}/add-media', 'ProverbController@addMedia')->name('proverbs.add-media');
Route::post('proverbs/{recipe}/annotated', 'ProverbController@flagAsAnnotated')->name('proverbs.flag-as-annotated');
Route::post('proverbs/{recipe}/validated', 'ProverbController@flagAsValidated')->name('proverbs.flag-as-validated');

Route::get('proverbs/{recipe}/alternative-versions', 'ProverbController@alternativeVersions')->name('proverbs.alternative-versions');
Route::get('proverbs/{recipe}/annotations', 'ProverbController@annotations')->name('proverbs.annotations');
Route::resource('proverbs', 'ProverbController');
Route::get('proverbs/user/{user}', 'ProverbController@user')->name('proverbs.user');



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
