<?php
Route::get('/logout', function (){
  Auth::logout();
  return redirect('/');
});
Route::auth();

Route::get('/testlogin', [
  'middleware' => ['auth'],
  'uses' => function () {
   echo "You are allowed to view this page!";
}]);

Route::get('/', 'HomeController@index');

Route::get('/default', 'HomeController@dflt');

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

Route::post('/users/login', 'UsersController@login');
Route::post('/users/forgot', 'UsersController@forgot');
Route::post('/users/register', 'UsersController@register');

// login HTML page
Route::get('/user/login-page', 'PagesController@userLogin');
Route::post('/user/login', 'UsersController@loginPage');
// new user HTML page
Route::get('/user/register-page', 'PagesController@userRegister');
Route::post('/users/register-nohashid', 'UsersController@registerNoHashid');

Route::get('/users/{user}/following', 'UsersController@following');
Route::get('/users/{user}/followers', 'UsersController@followers');
Route::get('/users/{user}/search/{query}', 'UsersController@search');

// user quiz
Route::get('/users/{user}/quiz', 'QuizController@getQuizUser');
Route::post('/users/{user}/quiz-completed', 'QuizController@completeQuizUser');
Route::get('/users/{user}/quiz-answers', 'QuizController@getQuizAnswersUser');

// Keep session when switching pages
Route::group(['middleware' => ['web']], function () {

  Route::post('/pages/{page}/update-page-about', 'PagesController@updatePageAbout');
  Route::post('/pages/{page}/update-page-categories', 'PagesController@updatePageCategories');


  // User HTML page
  Route::get('/user/{slug}/{user_unique_id}', 'PagesController@userPage');
  // User HTML page selected on DB id
  Route::get('/user/{user}', ['as' => 'user', 'uses' => 'UsersController@userPageId']);
  // Browser show all users
  Route::get('/users', 'UsersController@index');
  // user quiz for browser
  Route::get('/users/{user}/quizpage', 'QuizController@getQuizUserPage');
  // save quiz answer from browser
  Route::post('/users/{user}/quiz-answer', 'QuizController@saveQuizAnswer');
  Route::post('/users/{user}/quiz-completed-browser', 'QuizController@completeQuizUserFromBrowser');

  // page quiz for browser
  Route::get('/pages/{page}/quizpage', 'QuizController@getQuizPageB');
  // save quiz answer from browser
  Route::post('/pages/{page}/quiz-answer', 'QuizController@saveQuizAnswerPage');
  Route::post('/pages/{page}/quiz-completed-browser', 'QuizController@completeQuizPageFromBrowser');
  Route::post('/users/{user}/b-reviews', 'ReviewsController@storeB');

  Route::post('/users/{user}/follow-page-browser/{page}', 'UsersController@followPageBrowser');
  Route::post('/users/{user}/unfollow-page-browser/{page}', 'UsersController@unFollowPageBrowser');

  Route::post('/users/{following}/follow-user-browser/{followed}', 'UsersController@followUserBrowser');
  Route::post('/users/{following}/unfollow-user-browser/{followed}', 'UsersController@unFollowUserBrowser');
  // pages
  Route::get('/page/{slug}/{page}', 'PagesController@companyPage');
  Route::get('/pages', 'PagesController@index');

  Route::get('/pages/claim/{page}', 'PagesController@claimCompanyPage');
  Route::post('/pages/{page}/claimPage', 'PagesController@claimPage');
  // Route::get('/pages/edit/{page}', 'PagesController@editCompanyPage');
  Route::post('/users/{user}/upload-profile-image-page', 'UsersController@uploadProfileImagePage');
  Route::post('/users/{user}/update-bio-page', 'UsersController@updateBioPage');

  Route::post('/b-tips', 'TipsController@storeB');
  Route::post('/b-tips/{tip}/comments', 'TipsController@postCommentB');
  Route::post('/b-tips/{tip}/hearts', 'TipsController@heartsB');

  Route::post('/users/{user}/b-goals', 'GoalsController@storeB');
  Route::get('/users/{user}/b-goals/{goal}/delete', 'GoalsController@deleteB');
  Route::post('/users/{user}/b-goals/{goal}', 'GoalsController@updateB');
});


Route::get('/users/{user}/feed', 'UsersController@feed');
Route::post('/users/{user}/upload-profile-image', 'UsersController@uploadProfileImage');
// New add image from browser

Route::post('/users/{user}/update-profile', 'UsersController@updateProfile');
Route::get('/users/{user}/activity', 'UsersController@activity');

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
// from browser
Route::post('/pages/{page}/updatePage', 'PagesController@updatePage');
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



Route::get('/users/{user}/goals', 'GoalsController@index');
Route::post('/users/{user}/goals', 'GoalsController@store');
Route::get('/goals/{goal}', 'GoalsController@show');
Route::get('/users/{user}/goals/{goal}/delete', 'GoalsController@delete');
Route::post('/users/{user}/goals/{goal}', 'GoalsController@update');

Route::post('/save-login', 'UsersController@store');
// FaceBook login routes
Route::get('/fbredirect', 'SocialAuthController@faceBookRedirect');
Route::get('/fbcallback', 'SocialAuthController@faceBookCallback');


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
