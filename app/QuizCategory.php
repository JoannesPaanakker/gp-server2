<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizCategory extends Model
{

    protected $table = 'quiz_categories';

    public function quiz()
    {
        return $this->belongsTo('App\Quiz', 'quiz_id');
    }

    public function questions()
    {
        return $this->hasMany('App\QuizQuestion', 'category_id');
    }

}
