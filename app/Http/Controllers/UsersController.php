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

        if($returning_user){
            return response()->json(['status' => 'success', 'new_user' => 'false', 'user_id' => $user->id]);
        }else{
            return response()->json(['status' => 'success', 'new_user' => 'true', 'user_id' => $user->id]);    
        }
        
    }



}
