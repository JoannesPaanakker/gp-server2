<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = [
        'google_place_id'
    ];

    
 
    public function reviews(){
        return $this->hasMany(Review::class);
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
            return env('APP_URL') . '/photos/default_page.jpg';
        }
    }

    public function getImages(){
        $images = [];
        if(count($this->photos) > 0){
            foreach($this->photos as $photo){
                $images[] = ['url' => env('APP_URL') . '/photos/' . $photo->id . '.jpg', 'id' => $photo->id];
            }
        }else{
            $images[] = ['url' => env('APP_URL') . '/photos/default_page.jpg', 'id' => 0];
        }
        return $images;
    }

    public function followed(){
        return $this->belongsToMany(User::class, 'follows')->withTimestamps();
    }
    
}
