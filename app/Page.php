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
    
}
