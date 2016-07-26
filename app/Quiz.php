<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{

    protected $table = 'quizes';

    public function categories()
    {
        return $this->hasMany('App\QuizCategory', 'quiz_id');
    }

}
