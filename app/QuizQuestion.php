<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{

    protected $table = 'quiz_questions';

    public function answers()
    {
        return $this->hasMany('App\QuizPossibleAnswer');
    }

}
