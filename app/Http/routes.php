<?php

Route::get('/', 'HomeController@index');

Route::get('/users/{user}/pages', 'PagesController@userPages');
Route::post('/users/{user}/pages', 'PagesController@store');
Route::get('/users/{user}/reviews', 'ReviewsController@userReviews');
Route::post('/users/{user}/reviews', 'ReviewsController@store');
Route::post('/users/{user}/quiz-completed', 'UsersController@quizCompleted');
Route::post('/users/{user}/follow-page/{page}', 'UsersController@followPage');
Route::post('/users/{user}/unfollow-page/{page}', 'UsersController@unFollowPage');

Route::get('/users/{user}/feed', 'UsersController@feed');

Route::get('/pages', 'PagesController@index');
Route::get('/pages/{page}', 'PagesController@show');
Route::get('/pages/search/{query}/{position}', 'PagesController@search');
Route::post('/pages/{page}/images', 'PagesController@addImage');
Route::get('/pages/{page}/reviews', 'ReviewsController@pageReviews');
Route::post('/pages/get-by-id', 'PagesController@getById');
Route::get('/pages/nearby/{coordinates}', 'PagesController@getPagesNearBy');
Route::get('/pages-and-places/nearby/{coordinates}', 'PagesController@getPagesAndPlacesNearby');
Route::get('/places/nearby/{coordinates}', 'PagesController@getPlacesNearBy');
Route::post('/pages/{page}/update', 'PagesController@update');
Route::post('/pages/{page}/delete', 'PagesController@delete');
Route::get('/pages/{page}/feed', 'PagesController@pageFeed');

Route::get('/reviews', 'ReviewsController@index');
Route::get('/reviews/{review}', 'ReviewsController@show');
Route::post('/reviews/{review}/update', 'ReviewsController@update');
Route::post('/reviews/{review}/delete', 'ReviewsController@delete');
Route::post('/reviews/{review}/images', 'ReviewsController@addImage');

Route::post('/photos/{photo}/delete', 'PhotosController@delete');

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
