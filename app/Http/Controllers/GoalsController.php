<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Goal;
use App\Update;


class GoalsController extends Controller
{

	// list all goals for a user
    public function index(User $user){
    	$goals = $user->goals()->with('user')->get();
    	return $goals;
    }

    public function store(User $user){
    	$request = request()->all();
    	$goal = new Goal;
        $goal->title = $request['title'];
        $goal->content = $request['content'];
    	$goal->progress = $request['progress'];
    	$user->goals()->save($goal);

        // post update
        $update = new Update;
        $update->user_id = $user->id;
        $update->content = 'Has created a new goal';
        $update->kind = 'create-goal';
        $update->entity_id = $goal->id;
        $update->entity_name = $goal->title;
        $update->save();

    	return response()->json(['status' => 'success']);
    }

    public function show(User $user, Goal $goal){
        // TODO: check if the goal belongs to the user, otherwise 404
        return $goal;
    }

    public function delete(User $user, Goal $goal){
        // TODO: check if the goal belongs to the user, otherwise 404
        $goal->delete();
        return response()->json(['status' => 'success']);
    }

    public function update(User $user, Goal $goal){
        // TODO: check if the goal belongs to the user, otherwise 404
        $request = request()->all();
        $goal->title = $request['title'];
        $goal->content = $request['content'];
        $goal->progress = $request['progress'];
        // $goal->completed = ($request['completed'] == 'true') ? 1 : 0;
        $goal->save();
        return response()->json(['status' => 'success']);
    }

}
