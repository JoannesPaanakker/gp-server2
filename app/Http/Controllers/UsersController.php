<?php

namespace App\Http\Controllers;

use App\Page;
use App\Update;
use App\User;

class UsersController extends Controller
{

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

    public function feed(User $user)
    {
        // gets the ids of the pages followed by a user to an array
        $pages_followed = $user->following()->pluck('pages.id')->toArray();
        // get lateast 10 updates for those pages
        $updates = Update::whereIn('page_id', $pages_followed)->with('page')->orderBy('updated_at', 'desc')->take(10)->get();

        foreach ($updates as $update) {
            $update->formatted_date = $update->updated_at->diffForHumans();
        }
        return $updates;
    }

    public function quizCompleted(User $user)
    {
        $request = request()->all();
        $user->quiz_completed = 1;
        $user->quiz_score = $request['quiz_score'];
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function followPage(User $user, Page $page)
    {
        $user->following()->save($page);
        return response()->json(['status' => 'success']);
    }

    public function unFollowPage(User $user, Page $page)
    {
        $user->following()->detach($page);
        return response()->json(['status' => 'success']);
    }

}
