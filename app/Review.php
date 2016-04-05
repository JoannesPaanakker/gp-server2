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
    
}
