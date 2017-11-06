<?php

namespace App\Http\Controllers;

use App\Tip;
use App\Update;
use App\User;
use App\TipComment;
use Illuminate\Http\Request;
use Image;

class TipsController extends Controller
{
    public function index()
    {
        $tips = Tip::with('user')->orderBy('id', 'DESC')->get();
        return $tips;
    }

    public function show(Tip $tip)
    {
        $tip->user = $tip->user()->get()[0];
        $tip->comments = $tip->comments()->get();
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
        $tip->save();

        // upload the review photo
        $photo = request()->file('photo');
        if (!is_null($photo)) {
            $destinationPath = public_path() . '/tips-photos/';
            $path = $tip->id . '-orig.jpg';
            if ($photo->move($destinationPath, $path)) {
                Image::make($destinationPath . $tip->id . '-orig.jpg')->fit(500, 500)->save($destinationPath . $tip->id . '.jpg');
                $tip->picture = url('/tips-photos') . '/' . $tip->id . '.jpg';
                $tip->save();
            }
        }

        // post update
        $update = new Update;
        $update->user_id = $user->id;
        $update->content = 'Has created a new tip';
        $update->kind = 'create-tip';
        $update->entity_id = $tip->id;
        $update->entity_name = $tip->title;
        $update->save();

        $message = $user->first_name . ' ' . $user->last_name . ' has created a new tip';
        User::sendPushNotificationToMultipleUsers($user->followed_by, $message);

        return response()->json(['status' => 'success']);
    }

    public function postComment(Tip $tip){
        $comment = new TipComment;
        $comment->comment = request('comment');
        $comment->tip_id = $tip->id;
        $comment->user_id = request('user_id');
        $comment->save();
        return response()->json(['status' => 'success']);
    }

}
