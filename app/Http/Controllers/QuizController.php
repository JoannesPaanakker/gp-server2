<?php

namespace App\Http\Controllers;

use App\Page;
use App\Quiz;
use App\User;

class QuizController extends Controller
{

    // get quiz for pages
    public function getQuizPage()
    {
        $quiz = Quiz::where('id', 2)->with('categories.questions.answers')->get();
        return $quiz;
    }

    // get quiz for user
    public function getQuizUser()
    {
        $quiz = Quiz::where('id', 1)->with('categories.questions.answers')->get();
        return $quiz;
    }

    // complete quiz
    public function completeQuizUser(User $user)
    {
        $request = request()->all();
        dd($request['quiz_answers']);
        $user->quiz_completed = 1;
        $user->quiz_score = $request['quiz_score'];
        $user->save();
        return response()->json(['status' => 'success']);
    }

    public function quizResultPage()
    {
        $questions = QuizQuestion::where('for_pages', 1)->with('answers')->get();
        return $questions;
    }

    public function quizResultUser()
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
