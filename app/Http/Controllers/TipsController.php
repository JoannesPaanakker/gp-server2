<?php

namespace App\Http\Controllers;

use App\Tip;
use App\Update;
use App\User;
use Illuminate\Http\Request;

class TipsController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->orderBy('id', 'DESC')->get();
        return $tips;
    }

    public function show(Tip $tip)
    {
        $tip->user = $tip->user()->get();
        $tip->formatted_date = $tip->updated_at->diffForHumans();
        return $tip;
    }

    public function hearts(Tip $tip)
    {
        $tip->hearts = $tip->hearts + 1;
        $tip->save();
        return response()->json(['status' => 'success']);
    }

    public function store()
    {
        $request = request()->all();
        $user = User::find($request['userID']);
        $tip = new Tip;
        $tip->title = $request['title'];
        $tip->user_id = $request['userID'];
        $tip->content = $request['content'];
        $user->tips()->save($tip);

        // post update
        $update = new Update;
        $update->user_id = $user->id;
        $update->content = 'Has created a new tip';
        $update->kind = 'tip';
        $update->entity_id = $tip->id;
        $update->save();

        return response()->json(['status' => 'success']);
    }
}
