<?php

Route::get('/', 'HomeController@index');

// admin
Route::get('/admin', 'AdminController@index');
Route::get('/admin/companies/{order?}', 'AdminController@companies');

Route::get('/users/{user}', 'UsersController@show');
Route::get('/users/{user}/pages', 'PagesController@userPages');
Route::post('/users/{user}/pages', 'PagesController@store');
Route::get('/users/{user}/reviews', 'ReviewsController@userReviews');
Route::post('/users/{user}/reviews', 'ReviewsController@store');
Route::post('/users/{user}/follow-page/{page}', 'UsersController@followPage');
Route::post('/users/{user}/unfollow-page/{page}', 'UsersController@unFollowPage');
Route::post('/users/{following}/follow-user/{followed}', 'UsersController@followUser');
Route::post('/users/{following}/unfollow-user/{followed}', 'UsersController@unFollowUser');
Route::post('/users/{user}/facebook-friends', 'UsersController@facebookFriends');
Route::get('/user/{slug}/{user_unique_id}', 'PagesController@userPage');

Route::post('/users/login', 'UsersController@login');
Route::post('/users/forgot', 'UsersController@forgot');
Route::post('/users/register', 'UsersController@register');

Route::get('/users/{user}/following', 'UsersController@following');
Route::get('/users/{user}/followers', 'UsersController@followers');
Route::get('/users/{user}/search/{query}', 'UsersController@search');

// user quiz
Route::get('/users/{user}/quiz', 'QuizController@getQuizUser');
Route::post('/users/{user}/quiz-completed', 'QuizController@completeQuizUser');
Route::get('/users/{user}/quiz-answers', 'QuizController@getQuizAnswersUser');

Route::get('/users/{user}/feed', 'UsersController@feed');
Route::post('/users/{user}/upload-profile-image', 'UsersController@uploadProfileImage');
Route::post('/users/{user}/update-profile', 'UsersController@updateProfile');
Route::get('/users/{user}/activity', 'UsersController@activity');

Route::get('/pages', 'PagesController@index');
Route::get('/pages/{page}', 'PagesController@show');
Route::get('/pages/show-or-create/{page}', 'PagesController@showOrCreateFromGoogle');
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
Route::post('/tips/{tip}/comments', 'TipsController@postComment');
Route::post('/tips/{tip}/hearts', 'TipsController@hearts');

// pages
Route::get('/page/{slug}/{page_unique_id}', 'PagesController@companyPage');

Route::get('/users/{user}/goals', 'GoalsController@index');
Route::post('/users/{user}/goals', 'GoalsController@store');
Route::get('/goals/{goal}', 'GoalsController@show');
Route::get('/users/{user}/goals/{goal}/delete', 'GoalsController@delete');
Route::post('/users/{user}/goals/{goal}', 'GoalsController@update');

Route::post('/save-login', 'UsersController@store');

Route::get('/slug-users', function () {
	$users = \App\User::all();
	$hashids = new \Hashids\Hashids('', 5, '1234567890abcdef');

	foreach ($users as $user) {
		$user->unique_id = $hashids->encode($user->id);
		$user->slug = str_slug($user->first_name . ' ' . $user->last_name);
		$user->save();
	}
	dd('slug for users generated');
});

Route::get('/slug-page', function () {
	$pages = \App\Page::all();
	$hashids = new \Hashids\Hashids('', 5, '1234567890abcdef');

	foreach ($pages as $page) {
		$page->unique_id = $hashids->encode($page->id);
		$page->slug = str_slug($page->title);
		$page->save();
	}
	dd('slug for pages generated');
});

Route::get('/push-notification', function () {
	$deviceToken = request()->devicetoken;
	if (!$deviceToken) {
		abort(404);
	}

	$message = PushNotification::Message('Message Text',array(
	    'badge' => 1
	));

	$collection = PushNotification::app('iOS')
	    ->to($deviceToken)
	    ->send($message);

	/*
	PushNotification::app('iOS')
		->to($deviceToken)
		->send("Hello World, I'm a push message");
	*/
	return 'sent';
});
