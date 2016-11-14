<?php

Route::get('/', 'HomeController@index');

// admin
Route::get('/admin', 'AdminController@index');

Route::get('/users/{user}/pages', 'PagesController@userPages');
Route::post('/users/{user}/pages', 'PagesController@store');
Route::get('/users/{user}/reviews', 'ReviewsController@userReviews');
Route::post('/users/{user}/reviews', 'ReviewsController@store');
Route::post('/users/{user}/follow-page/{page}', 'UsersController@followPage');
Route::post('/users/{user}/unfollow-page/{page}', 'UsersController@unFollowPage');
Route::post('/users/{following}/follow-user/{followed}', 'UsersController@followUser');
Route::post('/users/{following}/unfollow-user/{followed}', 'UsersController@unFollowUser');
Route::post('/users/{user}/facebook-friends', 'UsersController@facebookFriends');
Route::post('/users/login', 'UsersController@login');
Route::post('/users/forgot', 'UsersController@forgot');

Route::get('/users/{user}/following', 'UsersController@following');
Route::get('/users/{user}/followers', 'UsersController@followers');
Route::get('/users/{user}/search/{query}', 'UsersController@search');

// user quiz
Route::get('/users/{user}/quiz', 'QuizController@getQuizUser');
Route::post('/users/{user}/quiz-completed', 'QuizController@completeQuizUser');
Route::get('/users/{user}/quiz-answers', 'QuizController@getQuizAnswersUser');

Route::get('/users/{user}/feed', 'UsersController@feed');
Route::get('/users/{user}/activity', 'UsersController@activity');

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
Route::post('/pages/{page}/feed', 'PagesController@postFeedUpdate');
Route::post('/pages/{page}/feed/{update}/photo', 'PagesController@addFeedUpdatePhoto');
Route::post('/pages/{page}/claim', 'PagesController@claim');

Route::get('/pages/{page}/quiz-answers', 'QuizController@getQuizAnswersPage');
Route::get('/pages/{page}/quiz', 'QuizController@getQuizPage');
Route::post('/pages/{page}/quiz-completed', 'QuizController@completeQuizPage');

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

Route::get('/push-notification', function () {
    $deviceToken = request()->devicetoken;
    if (!$deviceToken) {
        abort(404);
    }

    PushNotification::app('iOS')
        ->to($deviceToken)
        ->send("Hello World, I'm a push message");
    return 'sent';
});
