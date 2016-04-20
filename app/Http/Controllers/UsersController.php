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
        error_log(print_r($$request, 1));

    	$user = User::firstOrNew(['email' => $request['email']]);

		$user->first_name = $request['firstName'];
		$user->last_name = $request['lastName'];
		
        $returning_user = $user->exists;

		$user->save();

        if($returning_user){
            return response()->json(['status' => 'success', 'new_user' => 'false', 'user_id' => $user->id]);
        }else{
            return response()->json(['status' => 'success', 'new_user' => 'true', 'user_id' => $user->id]);    
        }
        
    }



}
