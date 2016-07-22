<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tip;
use App\User;

class TipsController extends Controller
{
    public function index(){
    	$tips = Tip::with('user')->orderBy('id', 'DESC')->get();
    	return $tips;
    }

    public function show(Tip $tip){
        $tip->user = $tip->user()->get();
        $tip-formatted_date = $tip->updated_at->diffForHumans();
        return $tip;
    }

    public function hearts(Tip $tip){
        $tip->hearts = $tip->hearts + 1;
        $tip->save();
        return response()->json(['status' => 'success']);
    }

    public function store(){
    	$request = request()->all();
    	$user = User::find($request['userID']);
    	$tip = new Tip;
    	$tip->title = $request['title'];
    	$tip->user_id = $request['userID'];
    	$tip->content = $request['content'];
    	$user->tips()->save($tip);

    	return response()->json(['status' => 'success']);
    }
}
