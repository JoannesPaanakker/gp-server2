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

    public function getThumb(){
    	$file = '/files/reviews/' . $this->id . '/thumb.jpg';
    	if(file_exists(public_path() . $file)){
    		return env('APP_URL') . $file;
    	}else{
    		return env('APP_URL') . '/files/reviews/default.jpg';
    	}
    }

    public function getImage(){
    	$file = '/files/reviews/' . $this->id . '/image.jpg';
    	if(file_exists(public_path() . $file)){
    		return env('APP_URL') . $file;
    	}else{
    		return env('APP_URL') . '/files/reviews/default.jpg';
    	}
    }
    
}
