<?php

namespace App\Http\Controllers;

use App\Page;
use App\Update;
use App\User;
use Image;

class UsersController extends Controller {

	public function search(User $user, $query) {
		$following = $user->following_users;
		$found_users = User::where('first_name', 'like', '%' . $query . '%')->orWhere('last_name', 'like', '%' . $query . '%')->get();
		foreach ($found_users as $found_user) {
			if ($following->contains($found_user)) {
				$found_user['is_followed_by_user'] = true;
			} else {
				$found_user['is_followed_by_user'] = false;
			}
		}
		return $found_users->toArray();
	}

	public function uploadProfileImage(User $user) {
		if (isset(request()->file)) {
			request()->file->move('profile-images', $user->id . '-orig.jpg');
			// generate thumbs
			Image::make('profile-images/' . $user->id . '-orig.jpg')->fit(500, 500)->save('profile-images/' . $user->id . '.jpg');
			$user->picture = 'http://www.greenplatform.org/profile-images/' . $user->id . '.jpg';
			$user->save();
		}
	}

	public function register() {
		$user = User::where('email', '=', request()->email)->first();
		if ($user) {
			return response()->json(['status' => 'fail', 'reason' => 'email already registered']);
		}

		$user = new User;
		$user->first_name = request()->firstname;
		$user->last_name = request()->lastname;
		$user->email = request()->email;
		$user->provider = 'email';
		$user->password = \Hash::make(request()->password);

		$hashids = new \Hashids\Hashids('', 5, '1234567890abcdef');
		$user->unique_id = $hashids->encode($user->id);
		$user->slug = str_slug($user->first_name . ' ' . $user->last_name);

		$user->save();

		return response()->json(['status' => 'success']);
	}

	public function facebookFriends(User $user) {

		$friends = request()->friends;
		$friend_ids = [];
		foreach ($friends as $friend) {
			$friend_ids[] = $friend['id'];
		}
		$users = User::whereIn('provider_id', $friend_ids)->get();
		return $users->toArray();
	}

	public function makePassword($length = 10) {
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$count = mb_strlen($chars);
		for ($i = 0, $result = ''; $i < $length; $i++) {
			$index = rand(0, $count - 1);
			$result .= mb_substr($chars, $index, 1);
		}
		return $result;
	}

	public function forgot() {
		$user = User::where('email', '=', request()->email)->first();
		if ($user) {
			$new_password = $this->makePassword();
			$user->password = \Hash::make($new_password);
			$user->save();
			// send email with the new password to the user
			return response()->json(['status' => 'success', 'password' => $new_password]);
		} else {
			return response()->json(['status' => 'wrong email']);
		}
	}

	public function login() {
		$user = User::where('email', '=', request()->email)->first();
		if ($user) {
			if (\Hash::check(request()->password, $user->password)) {
				return response()->json(['status' => 'success', 'quiz_completed' => $user->quiz_completed, 'user_id' => $user->id, 'first_name' => $user->first_name, 'last_name' => $user->last_name, 'email' => $user->email]);
			}
		}
		return response()->json(['status' => 'wrong email or password']);
	}

	public function store() {
		$request = request()->all();

		error_log('storing user');
		error_log(print_r($request, true));

		$user = User::firstOrNew(['email' => $request['email']]);

		$user->first_name = $request['firstName'];
		$user->last_name = $request['lastName'];
		$user->picture = $request['picture'];
		if ($request['deviceToken'] != 'null') {
			$user->device_token = $request['deviceToken'];
		}
		$user->provider = $request['provider'];
		$user->provider_id = $request['provider_id'];

		$returning_user = $user->exists;

		$user->save();


		$hashids = new \Hashids\Hashids('', 5, '1234567890abcdef');
		$user->unique_id = $hashids->encode($user->id);
		$user->slug = str_slug($user->first_name . ' ' . $user->last_name);

		$user->save();

		return response()->json(['status' => 'success', 'quiz_completed' => $user->quiz_completed, 'user_id' => $user->id]);
	}

	public function following(User $user) {
		$users = $user->following_users;
		foreach ($users as $user) {
			$user['is_followed_by_user'] = true;
		}
		return $users->toArray();
	}

	public function followers(User $user) {
		$followers = $user->followed_by;
		$following = $user->following_users;
		foreach ($followers as $follower) {
			if ($following->contains($follower)) {
				$follower['is_followed_by_user'] = true;
			} else {
				$follower['is_followed_by_user'] = false;
			}
		}
		return $followers->toArray();
	}

	// get a feed with all the recent activity for this user
	public function activity(User $user) {

		// get latest 10 updates for those pages
		$updates = Update::where('user_id', $user->id)->with('user')->orderBy('updated_at', 'desc')->take(10)->get();

		foreach ($updates as $update) {
			if ($update->with_image == '1') {
				$update->image = $update->getImage();
			}
			if ($update->page) {
				$update->page->thumb = $update->page->getThumb();
			}
			if ($update->user) {
				$update->user->thumb = $update->user->picture;
			}
			$update->formatted_date = $update->updated_at->diffForHumans();
		}
		$user->followed = $user->followed_by()->get();

		// get number of reviews
		$user->num_reviews = $user->reviews()->count();

		return ['feed' => $updates, 'user' => $user];

	}

	// get the feed with all the activiy from the following users
	public function feed(User $user) {

		// gets the ids of the pages followed by a user to an array
		$pages_followed = $user->following_pages()->pluck('page_id')->toArray();
		$users_followed = $user->following_users()->pluck('follow_id')->toArray();

		// get lateast 10 updates for those pages
		$updates = Update::whereIn('page_id', $pages_followed)->orWhereIn('user_id', $users_followed)->with('page')->with('user')->orderBy('updated_at', 'desc')->take(10)->get();

		foreach ($updates as $update) {
			if ($update->with_image == '1') {
				$update->image = $update->getImage();
			}
			if ($update->page) {
				$update->page->thumb = $update->page->getThumb();
			}
			if ($update->user) {
				$update->user->thumb = $update->user->picture;
			}
			$update->formatted_date = $update->updated_at->diffForHumans();
		}
		$user->followed = $user->followed_by()->get();

		// get number of reviews
		$user->num_reviews = $user->reviews()->count();

		return ['feed' => $updates, 'user' => $user];

	}

	public function followPage(User $user, Page $page) {
		$user->following_pages()->save($page);

		// post update
		$update = new Update;
		$update->user_id = $user->id;
		$update->content = 'Is now following ' . $page->title;
		$update->kind = 'follow-page';
		$update->entity_id = $page->id;
		$update->entity_name = $page->title;
		$update->save();
		if ($page->user) {
			$page->user->sendEmail('You have a new follower! ', '<b>' . $user->first_name . ' ' . $user->last_name . '</b> is now following your page <b>' . $page->title . '</b>!');
		}

		return response()->json(['status' => 'success']);
	}

	public function unFollowPage(User $user, Page $page) {
		$user->following_pages()->detach($page);
		return response()->json(['status' => 'success']);
	}

	public function followUser(User $following, User $followed) {

		$followed->sendPushNotification($following->first_name . ' ' . $following->last_name . ' is following you');

		$followed->sendEmail('You have a new follower! ', '<b>' . $following->first_name . ' ' . $following->last_name . '</b> is now following you!');

		// try to unfollow and follow again, to be sure only one record exists in the db
		$following->following_users()->detach($followed);
		$following->following_users()->save($followed);

		return response()->json(['status' => 'success']);
	}

	public function unFollowUser(User $following, User $followed) {
		$following->following_users()->detach($followed);
		return response()->json(['status' => 'success']);
	}

}
