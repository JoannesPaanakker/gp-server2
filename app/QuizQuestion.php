<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{

    protected $table = 'quiz_questions';

    public function category()
    {
        return $this->belongsTo('App\QuizCategory', 'category_id');
    }

    public function answers()
    {
        return $this->hasMany('App\QuizPossibleAnswer', 'question_id');
    }

}
