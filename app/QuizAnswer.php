<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{

    protected $table = 'quiz_answers';

    public function page()
    {
        return $this->belongsTo('App\Page');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

}
