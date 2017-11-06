<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipComment extends Model
{
   	public function user(){
   		return $this->belongsTo(User::class);
   	}
   	public function tip(){
   		return $this->belongsTo(Tip::class);
   	}
}
