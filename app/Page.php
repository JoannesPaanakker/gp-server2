<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
 
    public function reviews(){
        return $this->hasMany(Review::class);
    }
    
    public function user(){
        return $this->belongsTo(User::class);
    }


    public function getThumb(){
    	$file = '/files/pages/' . $this->id . '/thumb.jpg';
    	if(file_exists(public_path() . $file)){
    		return env('APP_URL') . $file;
    	}else{
    		return env('APP_URL') . '/files/pages/default.jpg';
    	}
    }

    public function getImage(){
    	$file = '/files/pages/' . $this->id . '/image.jpg';
    	if(file_exists(public_path() . $file)){
    		return env('APP_URL') . $file;
    	}else{
    		return env('APP_URL') . '/files/pages/default.jpg';
    	}
    }
    
}
