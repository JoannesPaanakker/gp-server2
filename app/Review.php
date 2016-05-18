<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Review extends Model
{

    public function page(){
        return $this->belongsTo(Page::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function photos(){
        return $this->hasMany(Photo::class);
    }

    public function getThumb(){
        if(count($this->photos) > 0){
            return env('APP_URL') . '/photos/' . $this->photos[0]->id . '_thumb.jpg';
        }else{
            return env('APP_URL') . '/photos/default_review.jpg';
        }
    }

    public function getImages(){
    	if(count($this->photos) > 0){
            $images = [];
            foreach($this->photos as $photo){
                $images[] = ['url' => env('APP_URL') . '/photos/' . $photo->id . '.jpg', 'id' => $photo->id];
            }
            return $images;
        }else{
            return ['url' => env('APP_URL') . '/photos/default_review.jpg', 'id' => 0];
        }
    }
    
}
