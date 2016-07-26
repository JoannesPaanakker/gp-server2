<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizPossibleAnswer extends Model
{

    protected $table = 'quiz_possible_answers';

    public function question()
    {
        return $this->belongsTo('App\QuizQuestion', 'question_id');
    }

}
