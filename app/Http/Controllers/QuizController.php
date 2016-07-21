<?php

namespace App\Http\Controllers;

use App\Page;
use App\QuizQuestion;

class QuizController extends Controller
{

    public function page()
    {
        $questions = QuizQuestion::where('for_pages', 1)->with('answers')->get();
        return $questions;
    }

    public function user()
    {
        $questions = QuizQuestion::where('for_users', 1)->with('answers')->get();
        return $questions;
    }

    // get answers (quiz result) for a page
    public function answers(Page $page)
    {
        $answers = $page->quizAnswers()->get();
        return $answers;
    }

}
