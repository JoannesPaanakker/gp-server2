<?php

namespace App\Http\Controllers;

use App\Page;
use App\Update;
use App\User;

class UsersController extends Controller
{

    public function search(User $user, $query)
    {
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

    public function facebookFriends(User $user)
    {

        $friends = request()->friends;
        $friend_ids = [];
        foreach ($friends as $friend) {
            $friend_ids[] = $friend['id'];
        }
        $users = User::whereIn('provider_id', $friend_ids)->get();
        return $users->toArray();
    }

    public function store()
    {
        $request = request()->all();

        error_log('storing user');
        error_log(print_r($request, true));

        $user = User::firstOrNew(['email' => $request['email']]);

        $user->first_name = $request['firstName'];
        $user->last_name = $request['lastName'];
        $user->picture = $request['picture'];
        $user->provider = $request['provider'];
        $user->provider_id = $request['provider_id'];

        $returning_user = $user->exists;

        $user->save();

        return response()->json(['status' => 'success', 'quiz_completed' => $user->quiz_completed, 'user_id' => $user->id]);
    }

    public function following(User $user)
    {
        $users = $user->following_users;
        foreach ($users as $user) {
            $user['is_followed_by_user'] = true;
        }
        return $users->toArray();
    }

    public function followers(User $user)
    {
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
    public function activity(User $user)
    {

        // get lateast 10 updates for those pages
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
    public function feed(User $user)
    {

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

    public function followPage(User $user, Page $page)
    {
        $user->following_pages()->save($page);

        // post update
        $update = new Update;
        $update->user_id = $user->id;
        $update->content = 'Is now following ' . $page->title;
        $update->kind = 'follow-page';
        $update->entity_id = $page->id;
        $update->entity_name = $page->title;
        $update->save();

        return response()->json(['status' => 'success']);
    }

    public function unFollowPage(User $user, Page $page)
    {
        $user->following_pages()->detach($page);
        return response()->json(['status' => 'success']);
    }

    public function followUser(User $following, User $followed)
    {
        // check if the user is not already following
        $followers = $followed->following_users;
        if (!$followers->contains($following)) {
            $following->following_users()->save($followed);
        }

        return response()->json(['status' => 'success']);
    }

    public function unFollowUser(User $following, User $followed)
    {
        $following->following_users()->detach($followed);
        return response()->json(['status' => 'success']);
    }

}
