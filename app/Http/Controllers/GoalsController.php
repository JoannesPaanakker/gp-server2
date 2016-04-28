<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Goal;


class GoalsController extends Controller
{


	// list all goals for a user
    public function index(User $user){
    	$goals = $user->goals()->get();
    	return $goals;
    }

    public function store(User $user){
    	$request = request()->all();
    	$goal = new Goal;
    	$goal->title = $request['title'];
    	$user->goals()->save($goal);
    	return response()->json(['status' => 'success']);
    }

     public function show(User $user, Goal $goal){
        // TODO: check if the goal belongs to the user, otherwise 404
        return $goal;
    }


}
