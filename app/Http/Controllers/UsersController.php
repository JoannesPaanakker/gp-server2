<?php

namespace App\Http\Controllers;


use App\User;
use App\Page;
use App\Review;

class UsersController extends Controller
{
    
    public function store(){
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


    public function quizCompleted(User $user){
        $request = request()->all();
        $user->quiz_completed = 1;
        $user->quiz_score = $request['quiz_score'];
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function followPage(User $user, Page $page){
        $user->following()->save($page);
        return response()->json(['status' => 'success']);
    }

    public function unFollowPage(User $user, Page $page){
        $user->following()->detach($page);
        return response()->json(['status' => 'success']);
    }

}
