<?php


/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return 'Green Platform API';
});

Route::get('/users/{user}/pages', 'PagesController@userPages');
Route::post('/users/{user}/pages', 'PagesController@store');
Route::get('/users/{user}/reviews', 'ReviewsController@userReviews');
Route::post('/users/{user}/reviews', 'ReviewsController@store');
Route::post('/users/{user}/quiz-completed', 'UsersController@quizCompleted');

Route::get('/pages', 'PagesController@index');
Route::get('/pages/{page}', 'PagesController@show');
Route::get('/pages/search/{query}', 'PagesController@search');
Route::post('/pages/{page}/images', 'PagesController@addImage');
Route::get('/pages/{page}/reviews', 'ReviewsController@pageReviews');
Route::post('/pages/get-by-id', 'PagesController@getById');
Route::get('/pages/nearby/{coordinates}', 'PagesController@getPagesNearBy');
Route::get('/places/nearby/{coordinates}', 'PagesController@getPlacesNearBy');

Route::get('/reviews', 'ReviewsController@index');
Route::get('/reviews/{review}', 'ReviewsController@show');
Route::post('/reviews/{review}/images', 'ReviewsController@addImage');

Route::get('/tips', 'TipsController@index');
Route::get('/tips/{tip}', 'TipsController@show');
Route::post('/tips', 'TipsController@store');
Route::post('/tips/{tip}/hearts', 'TipsController@hearts');

Route::get('/users/{user}/goals', 'GoalsController@index');
Route::post('/users/{user}/goals', 'GoalsController@store');
Route::get('/users/{user}/goals/{goal}', 'GoalsController@show');
Route::get('/users/{user}/goals/{goal}/delete', 'GoalsController@delete');
Route::post('/users/{user}/goals/{goal}', 'GoalsController@update');

Route::post('/save-login', 'UsersController@store');


Route::auth();

Route::get('/home', 'HomeController@index');
