<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Photo extends Model
{
    public function review(){
        return $this->belongsTo(Review::class);
    }
    public function page(){
        return $this->belongsTo(Page::class);
    }
}
