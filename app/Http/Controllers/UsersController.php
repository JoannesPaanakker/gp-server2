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
    	$user = User::firstOrNew(['email' => $request['email']]);

		$user->first_name = $request['firstName'];
		$user->last_name = $request['lastName'];
		
		$user->save();

        return response()->json(['status' => 'success', 'user_id' => $user->id]);
    }



}
